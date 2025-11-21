<?php

namespace App\Livewire;

use App\Models\Inventory\Product;
use App\Models\Review;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SubmitReview extends Component
{
    public Product $product;
    public $rating = 0;
    public $comment = '';
    public $existingReview = null;
    public $isEditing = false;

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|min:10|max:1000',
    ];

    public function mount(Product $product)
    {
        $this->product = $product;
        
        // Verificar si el usuario ya tiene una review
        if (Auth::check()) {
            $this->existingReview = Review::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->first();

            if ($this->existingReview) {
                $this->isEditing = true;
                $this->rating = $this->existingReview->rating;
                $this->comment = $this->existingReview->comment;
            }
        }
    }

    public function setRating($value)
    {
        $this->rating = $value;
    }

    public function submit()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Debes iniciar sesión para dejar una reseña.');
            return redirect()->route('login');
        }

        $this->validate();

        if ($this->existingReview) {
            $this->existingReview->update([
                'rating' => $this->rating,
                'comment' => $this->comment,
                'status' => 'approved',
            ]);
            session()->flash('message', 'Tu reseña ha sido actualizada exitosamente.');
        } else {
            Review::create([
                'user_id' => Auth::id(),
                'product_id' => $this->product->id,
                'rating' => $this->rating,
                'comment' => $this->comment,
                'status' => 'approved', // Publicación directa
            ]);
            session()->flash('message', 'Tu reseña ha sido publicada exitosamente.');
        }

        // Solo resetear si es una nueva review
        if (!$this->existingReview) {
            $this->reset(['rating', 'comment']);
        } else {
            // Si es edición, mantenemos los valores actuales para que la UI no parpadee/cambie
            $this->rating = $this->existingReview->rating;
            $this->comment = $this->existingReview->comment;
        }
        
        // Recargar reviews
        $this->dispatch('reviewSubmitted');
    }

    public function render()
    {
        return view('livewire.ecommerce.submit-review');
    }
}
