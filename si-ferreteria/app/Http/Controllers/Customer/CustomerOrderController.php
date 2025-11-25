<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    /**
     * Display a listing of the customer's orders.
     */
    public function index()
    {
        // Get online sales
        $onlineSales = Sale::with(['payment.paymentMethod', 'saleDetails.product'])
            ->where('customer_id', Auth::id())
            ->where('sale_type', 'online')
            ->get()
            ->map(function ($sale) {
                $sale->sale_type_display = 'online';
                return $sale;
            });

        // Get in-person sales
        $inPersonSales = \App\Models\SaleUnperson::with(['payment.paymentMethod', 'saleDetails.product'])
            ->where('customer_id', Auth::id())
            ->get()
            ->map(function ($sale) {
                $sale->sale_type_display = 'presencial';
                // Map status to match online sales format for consistency
                $sale->status_mapped = match($sale->status) {
                    'paid' => 'paid',
                    'pending_payment' => 'pending',
                    'cancelled' => 'cancelled',
                    'draft' => 'processing',
                    default => $sale->status
                };
                return $sale;
            });

        // Merge and sort by creation date
        $orders = $onlineSales->concat($inPersonSales)
            ->sortByDesc('created_at')
            ->values();

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        // Try to find as online sale first
        $order = Sale::with(['payment.paymentMethod', 'saleDetails.product', 'deliveredBy'])
            ->where('customer_id', Auth::id())
            ->where('sale_type', 'online')
            ->find($id);

        if ($order) {
            $order->sale_type_display = 'online';
            return view('customer.orders.show', compact('order'));
        }

        // If not found, try as in-person sale
        $order = \App\Models\SaleUnperson::with(['payment.paymentMethod', 'saleDetails.product'])
            ->where('customer_id', Auth::id())
            ->findOrFail($id);

        $order->sale_type_display = 'presencial';
        $order->status_mapped = match($order->status) {
            'paid' => 'paid',
            'pending_payment' => 'pending',
            'cancelled' => 'cancelled',
            'draft' => 'processing',
            default => $order->status
        };

        return view('customer.orders.show', compact('order'));
    }

    /**
     * Cancel the specified order.
     */
    public function cancel($id)
    {
        $order = Sale::where('customer_id', Auth::id())
            ->where('sale_type', 'online')
            ->findOrFail($id);

        // Check if order can be cancelled
        if (!$order->canBeCancelled()) {
            return redirect()
                ->route('customer.orders.show', $id)
                ->with('error', __('Este pedido no puede ser cancelado.'));
        }

        // Cancel the order
        $order->cancel();

        return redirect()
            ->route('customer.orders.show', $id)
            ->with('success', __('Tu pedido ha sido cancelado exitosamente.'));
    }
}
