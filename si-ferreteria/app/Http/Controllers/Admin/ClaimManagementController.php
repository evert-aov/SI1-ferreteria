<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaimManagementController extends Controller
{
    /**
     * Display a listing of all claims (admin view).
     */
    public function index(Request $request)
    {
        $query = Claim::with(['customer', 'saleDetail.product', 'reviewedBy'])
            ->orderBy('created_at', 'desc');

        // Filter by status if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $claims = $query->paginate(20);

        return view('admin.claims.index', compact('claims'));
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

        return view('admin.claims.show', compact('claim'));
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

        return redirect()->route('admin.claims.show', $claim->id)
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

        return redirect()->route('admin.claims.index')
            ->with('success', 'Reclamo eliminado exitosamente.');
    }
}
