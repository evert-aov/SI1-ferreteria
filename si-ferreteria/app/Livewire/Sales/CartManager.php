<?php
namespace App\Livewire\Sales;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Inventory\Product;
use Illuminate\Contracts\View\View;

class CartManager extends Component
{
    use WithPagination;

    protected $cartItems = [];

    public function render(): View
    {
        

        return view('livewire.sales.cart-manager', [
            'products' => Product::paginate(10),
        ]);
    }

    public function addItem($itemId, $quantity)
    {
        if (isset($this->cartItems[$itemId])) {
            $this->cartItems[$itemId] += $quantity;
        } else {
            $this->cartItems[$itemId] = $quantity;
        }
    }

    public function removeItem($itemId)
    {
        unset($this->cartItems[$itemId]);
    }

    public function updateItemQuantity($itemId, $quantity)
    {
        if (isset($this->cartItems[$itemId])) {
            $this->cartItems[$itemId] = $quantity;
        }
    }

    public function getCartItems()
    {
        return $this->cartItems;
    }

    public function clearCart()
    {
        $this->cartItems = [];
    }
}
