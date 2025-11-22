<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseHistoryController extends Controller
{
    /**
     * Display the authenticated user's purchase history.
     */
    public function index()
    {
        // Get the authenticated user's ID
        $userId = Auth::id();
        
        // Get all online sales for this customer with related data
        $onlineSales = Sale::where('customer_id', $userId)
            ->with([
                'saleDetails.product.category',
                'saleDetails.product.brand',
                'saleDetails.product.color',
                'payment.paymentMethod'
            ])
            ->get()
            ->map(function ($sale) {
                $sale->sale_type_display = 'online';
                return $sale;
            });
        
        // Get all in-person sales for this customer with related data
        $inPersonSales = \App\Models\SaleUnperson::where('customer_id', $userId)
            ->with([
                'saleDetails.product.category',
                'saleDetails.product.brand',
                'saleDetails.product.color',
                'payment.paymentMethod'
            ])
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
        
        // Merge both collections and sort by creation date (newest first)
        $purchases = $onlineSales->concat($inPersonSales)
            ->sortByDesc('created_at')
            ->values();
        
        return view('purchase-history.index', compact('purchases'));
    }
}
