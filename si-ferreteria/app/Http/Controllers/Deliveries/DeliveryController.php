<?php

namespace App\Http\Controllers\Deliveries;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    /**
     * Display a listing of pending deliveries.
     */
    public function index(Request $request)
    {
        $query = Sale::with(['customer', 'saleDetails.product'])
            ->where('sale_type', 'online')
            ->whereIn('status', ['paid', 'preparing', 'shipped'])
            ->orderBy('created_at', 'desc');

        // Filter by status if provided
        if ($request->has('status') && in_array($request->status, ['paid', 'preparing', 'shipped'])) {
            $query->where('status', $request->status);
        }

        // Search by invoice number or customer name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $deliveries = $query->paginate(15);

        return view('deliveries.index', compact('deliveries'));
    }

    /**
     * Display the specified delivery.
     */
    public function show($id)
    {
        $sale = Sale::with(['customer', 'payment.paymentMethod', 'saleDetails.product', 'deliveredBy'])
            ->where('sale_type', 'online')
            ->findOrFail($id);

        return view('deliveries.show', compact('sale'));
    }

    /**
     * Mark an order as delivered.
     */
    public function markAsDelivered(Request $request, $id)
    {
        $sale = Sale::where('sale_type', 'online')
            ->whereIn('status', ['paid', 'preparing', 'shipped'])
            ->findOrFail($id);

        // Mark as delivered with the current user as the delivery person
        $sale->markAsDelivered(Auth::id());

        return redirect()
            ->route('deliveries.index')
            ->with('success', __('Pedido marcado como entregado exitosamente.'));
    }
}
