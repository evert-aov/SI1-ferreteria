<?php

namespace App\Livewire\Ecommerce;

use App\Models\Inventory\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductReviews extends Component
{
    use WithPagination;

    public Product $product;
    public $filterRating = null;
    public $sortBy = 'recent'; // recent, helpful

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function filterByRating($rating)
    {
        $this->filterRating = $rating === $this->filterRating ? null : $rating;
        $this->resetPage();
    }

    public function sortByRecent()
    {
        $this->sortBy = 'recent';
        $this->resetPage();
    }

    public function sortByHelpful()
    {
        $this->sortBy = 'helpful';
        $this->resetPage();
    }

    public function markAsHelpful($reviewId)
    {
        $review = \App\Models\Review::find($reviewId);
        if ($review) {
            $review->increment('helpful_count');
            session()->flash('message', '¡Gracias por tu feedback!');
        }
    }


    public function render()
    {
        $query = $this->product->approvedReviews()->with('user');

        // Aplicar filtro de rating
        if ($this->filterRating) {
            $query->where('rating', $this->filterRating);
        }

        // Aplicar ordenamiento
        if ($this->sortBy === 'helpful') {
            $query->orderBy('helpful_count', 'desc');
        } else {
            $query->latest();
        }

        $reviews = $query->paginate(10);

        return view('livewire.ecommerce.product-reviews', [
            'reviews' => $reviews,
            'averageRating' => $this->product->average_rating,
            'reviewsCount' => $this->product->reviews_count,
            'ratingDistribution' => $this->product->rating_distribution,
        ]);
    }
}
