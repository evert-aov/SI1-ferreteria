<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaimController extends Controller
{
    /**
     * Display a listing of all claims (admin view).
     */
    public function index(Request $request)
    {
        $query = Claim::with(['customer', 'saleDetail.product', 'reviewedBy'])
            ->orderBy('created_at', 'desc');

        // Check if user is admin
        $isAdmin = Auth::user()->roles->contains('name', 'Administrador');

        // If not admin, only show user's own claims
        if (!$isAdmin) {
            $query->where('customer_id', Auth::id());
        }

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $claims = $query->paginate(20)->withQueryString();

        return view('claims.index', compact('claims', 'isAdmin'));
    }

    /**
     * Display the specified claim (admin view).
     */
    public function show($id)
    {
        $claim = Claim::with([
            'customer',
            'saleDetail.product',
            'sale',
            'saleUnperson',
            'reviewedBy'
        ])->findOrFail($id);

        // Check if user is admin
        $isAdmin = Auth::user()->roles->contains('name', 'Administrador');

        // If not admin, verify the claim belongs to the user
        if (!$isAdmin && $claim->customer_id !== Auth::id()) {
            abort(403, 'No autorizado para ver este reclamo.');
        }

        return view('claims.show', compact('claim', 'isAdmin'));
    }

    /**
     * Show the form for creating a new claim.
     */
    public function create($saleDetailId)
    {
        $saleDetail = \App\Models\SaleDetail::with(['product', 'sale', 'saleUnperson'])
            ->findOrFail($saleDetailId);

        // Verify this sale detail belongs to the authenticated user
        $customerId = $saleDetail->sale?->customer_id ?? $saleDetail->saleUnperson?->customer_id;

        if ($customerId !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        // Check if claim can be created
        if (!Claim::canCreateClaim($saleDetailId)) {
            return redirect()->route('customer.orders.index')
                ->with('error', 'No se puede crear un reclamo para este producto. Puede que ya exista un reclamo o hayan pasado más de 15 días desde la compra.');
        }

        // Return modal view for AJAX requests
        if (request()->ajax() || request()->wantsJson()) {
            return view('claims.create-modal', compact('saleDetail'));
        }

        // If accessed directly (not AJAX), redirect to orders page
        return redirect()->route('customer.orders.index')
            ->with('info', 'Por favor, solicite el reclamo desde la página de detalles de su pedido.');
    }

    /**
     * Store a newly created claim in storage.
     */
    public function store(Request $request)
    {
        \Log::info('=== CLAIM STORE METHOD STARTED ===', [
            'has_file' => $request->hasFile('evidence'),
            'all_data' => $request->except('evidence'),
        ]);

        $validated = $request->validate([
            'sale_detail_id' => 'required|exists:sale_details,id',
            'claim_type' => 'required|in:defecto,devolucion,reembolso,garantia,otro',
            'description' => 'required|string|max:1000',
            'evidence' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240', // 10MB max
        ]);

        \Log::info('Validation passed', ['validated' => $validated]);

        // Verify ownership and claim eligibility
        $saleDetail = \App\Models\SaleDetail::findOrFail($validated['sale_detail_id']);
        $customerId = $saleDetail->sale?->customer_id ?? $saleDetail->saleUnperson?->customer_id;

        if ($customerId !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        // Check daily claim limit (5 claims per day)
        $todayClaimsCount = Claim::where('customer_id', Auth::id())
            ->whereDate('created_at', today())
            ->count();

        if ($todayClaimsCount >= 5) {
            return redirect()->route('customer.orders.index')
                ->with('error', 'Has alcanzado el límite de 5 reclamos por día. Por favor intenta mañana.');
        }

        if (!Claim::canCreateClaim($validated['sale_detail_id'])) {
            return redirect()->route('customer.orders.index')
                ->with('error', 'No se puede crear un reclamo para este producto.');
        }

        // Handle file upload with Cloudinary
        $evidencePath = null;
        if ($request->hasFile('evidence')) {
            try {
                // Configure Cloudinary
                \Cloudinary\Configuration\Configuration::instance([
                    'cloud' => [
                        'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                        'api_key' => env('CLOUDINARY_API_KEY'),
                        'api_secret' => env('CLOUDINARY_API_SECRET'),
                    ],
                    'url' => [
                        'secure' => true
                    ]
                ]);

                // Upload to Cloudinary
                $uploadedFile = $request->file('evidence');
                \Log::info('Attempting Cloudinary upload', [
                    'filename' => $uploadedFile->getClientOriginalName(),
                    'size' => $uploadedFile->getSize(),
                    'mime' => $uploadedFile->getMimeType(),
                ]);

                $result = (new \Cloudinary\Api\Upload\UploadApi())->upload(
                    $uploadedFile->getRealPath(),
                    [
                        'folder' => 'claims',
                        'resource_type' => 'auto',
                        'public_id' => 'claim_' . time() . '_' . uniqid(),
                    ]
                );

                // Store the secure_url
                $evidencePath = $result['secure_url'];
                \Log::info('Cloudinary upload successful', ['url' => $evidencePath]);

            } catch (\Exception $e) {
                \Log::error('Cloudinary upload failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);

                // Fallback to local storage
                try {
                    $evidencePath = $request->file('evidence')->store('claims', 'public');
                    $evidencePath = asset('storage/' . $evidencePath);
                    \Log::info('Fallback to local storage successful', ['path' => $evidencePath]);
                } catch (\Exception $localError) {
                    \Log::error('Local storage fallback also failed', ['error' => $localError->getMessage()]);
                    return redirect()->back()
                        ->with('error', 'Error al subir la evidencia. Por favor intente nuevamente.')
                        ->withInput();
                }
            }
        }

        // Create claim
        $claim = Claim::create([
            'customer_id' => Auth::id(),
            'sale_id' => $saleDetail->sale_id,
            'sale_unperson_id' => $saleDetail->sale_unperson_id,
            'sale_detail_id' => $validated['sale_detail_id'],
            'claim_type' => $validated['claim_type'],
            'description' => $validated['description'],
            'evidence_path' => $evidencePath,
            'status' => 'pendiente',
        ]);

        // Always return JSON response (modal form uses AJAX)
        return response()->json([
            'success' => true,
            'message' => 'Reclamo enviado exitosamente. Será revisado por nuestro equipo.',
            'claim_id' => $claim->id
        ]);
    }

    /**
     * Update the status of a claim.
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pendiente,en_revision,aprobada,rechazada',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $claim = Claim::findOrFail($id);

        $claim->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? $claim->admin_notes,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Estado del reclamo actualizado exitosamente.'
            ]);
        }

        return redirect()->route('claims.show', $claim->id)
            ->with('success', 'Estado del reclamo actualizado exitosamente.');
    }

    /**
     * Delete a claim (admin only).
     */
    public function destroy($id)
    {
        $claim = Claim::findOrFail($id);

        // Delete the claim (will trigger model event to delete evidence file)
        $claim->delete();

        return redirect()->route('claims.index')
            ->with('success', 'Reclamo eliminado exitosamente.');
    }
}
