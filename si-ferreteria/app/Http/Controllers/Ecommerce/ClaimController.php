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

        return view('claims.create', compact('saleDetail'));
    }

    /**
     * Store a newly created claim in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sale_detail_id' => 'required|exists:sale_details,id',
            'claim_type' => 'required|in:defecto,devolucion,reembolso,garantia,otro',
            'description' => 'required|string|max:1000',
            'evidence' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
        ]);

        // Verify ownership and claim eligibility
        $saleDetail = SaleDetail::findOrFail($validated['sale_detail_id']);
        $customerId = $saleDetail->sale?->customer_id ?? $saleDetail->saleUnperson?->customer_id;
        
        if ($customerId !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        if (!Claim::canCreateClaim($validated['sale_detail_id'])) {
            return redirect()->route('purchase-history.index')
                ->with('error', 'No se puede crear un reclamo para este producto.');
        }

        // Handle file upload
        $evidencePath = null;
        if ($request->hasFile('evidence')) {
            $evidencePath = $request->file('evidence')->store('claims', 'public');
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

        return view('claims.show', compact('claim'));
    }
}
