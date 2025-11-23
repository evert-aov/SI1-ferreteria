<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClaimController extends Controller
{
    /**
     * Display a listing of the user's claims.
     */
    public function index()
    {
        $claims = Claim::where('customer_id', Auth::id())
            ->with(['saleDetail.product', 'sale', 'saleUnperson'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('claims.index', compact('claims'));
    }

    /**
     * Show the form for creating a new claim.
     */
    public function create($saleDetailId)
    {
        $saleDetail = SaleDetail::with(['product', 'sale', 'saleUnperson'])
            ->findOrFail($saleDetailId);

        // Verify this sale detail belongs to the authenticated user
        $customerId = $saleDetail->sale?->customer_id ?? $saleDetail->saleUnperson?->customer_id;
        
        if ($customerId !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        // Check if claim can be created
        if (!Claim::canCreateClaim($saleDetailId)) {
            return redirect()->route('purchase-history.index')
                ->with('error', 'No se puede crear un reclamo para este producto. Puede que ya exista un reclamo o hayan pasado más de 15 días desde la compra.');
        }

        // Return modal view for AJAX requests
        if (request()->ajax() || request()->wantsJson()) {
            return view('claims.create-modal', compact('saleDetail'));
        }
        
        return view('claims.create', compact('saleDetail'));
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
        $saleDetail = SaleDetail::findOrFail($validated['sale_detail_id']);
        $customerId = $saleDetail->sale?->customer_id ?? $saleDetail->saleUnperson?->customer_id;
        
        if ($customerId !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        // Check daily claim limit (5 claims per day)
        $todayClaimsCount = Claim::where('customer_id', Auth::id())
            ->whereDate('created_at', today())
            ->count();

        if ($todayClaimsCount >= 5) {
            return redirect()->route('purchase-history.index')
                ->with('error', 'Has alcanzado el límite de 5 reclamos por día. Por favor intenta mañana.');
        }

        if (!Claim::canCreateClaim($validated['sale_detail_id'])) {
            return redirect()->route('purchase-history.index')
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

        // Return JSON for AJAX requests
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Reclamo enviado exitosamente. Será revisado por nuestro equipo.',
                'claim_id' => $claim->id
            ]);
        }
        
        return redirect()->route('claims.show', $claim->id)
            ->with('success', 'Reclamo enviado exitosamente. Será revisado por nuestro equipo.');
    }

    /**
     * Display the specified claim.
     */
    public function show($id)
    {
        $claim = Claim::with(['saleDetail.product', 'sale', 'saleUnperson', 'reviewedBy'])
            ->findOrFail($id);

        // Verify ownership
        if ($claim->customer_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        // Return modal view for AJAX requests
        if (request()->ajax() || request()->wantsJson()) {
            return view('claims.show-modal', compact('claim'));
        }
        
        return view('claims.show', compact('claim'));
    }
}
