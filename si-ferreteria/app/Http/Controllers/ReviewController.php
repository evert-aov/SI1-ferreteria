<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Inventory\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Guardar o actualizar una review de un producto (Publicación directa)
     */
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        // Buscar si ya existe una review de este usuario para este producto
        $review = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($review) {
            // Actualizar review existente
            $review->update([
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
                'status' => 'approved', // Se aprueba automáticamente
            ]);

            session()->flash('message', 'Tu reseña ha sido actualizada exitosamente.');
        } else {
            // Crear nueva review (se aprueba automáticamente)
            Review::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
                'status' => 'approved',
            ]);

            session()->flash('message', 'Tu reseña ha sido publicada exitosamente.');
        }

        return redirect()->back();
    }

    /**
     * Marcar una review como útil
     */
    public function markHelpful(Review $review)
    {
        $review->increment('helpful_count');
        
        return response()->json([
            'success' => true,
            'helpful_count' => $review->helpful_count
        ]);
    }

    /**
     * Eliminar una review (solo el autor o admin)
     */
    public function destroy(Review $review)
    {
        // Verificar que el usuario sea el autor o admin
        $userRole = Auth::user()->getRolPrincipal();
        $isAdmin = $userRole && $userRole->name === 'Administrador';
        
        if (Auth::id() !== $review->user_id && !$isAdmin) {
            abort(403, 'No autorizado');
        }

        $review->delete();
        session()->flash('success', 'Reseña eliminada exitosamente.');
        
        return redirect()->back();
    }
    /**
     * Mostrar panel de moderación de reviews (Admin)
     */
    public function moderate(Request $request)
    {
        // Verificar rol de admin (esto también se puede hacer en middleware)
        $userRole = Auth::user()->getRolPrincipal();
        if (!$userRole || $userRole->name !== 'Administrador') {
            abort(403, 'No autorizado');
        }

        $query = Review::with(['user', 'product']);

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('product', function($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%");
            })->orWhereHas('user', function($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%");
            })->orWhere('comment', 'ILIKE', "%{$search}%");
        }

        $reviews = $query->latest()->paginate(20)->withQueryString();

        return view('admin.reviews.moderate', compact('reviews'));
    }
}
