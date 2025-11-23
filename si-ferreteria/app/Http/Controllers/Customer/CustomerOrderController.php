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
        $orders = Sale::with(['payment.paymentMethod', 'saleDetails.product'])
            ->where('customer_id', Auth::id())
            ->where('sale_type', 'online')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Sale::with(['payment.paymentMethod', 'saleDetails.product', 'deliveredBy'])
            ->where('customer_id', Auth::id())
            ->where('sale_type', 'online')
            ->findOrFail($id);

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
