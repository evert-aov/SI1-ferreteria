<?php

namespace App\Livewire\ExitNotes;

use Livewire\Component;
use App\Models\Inventory\Product;
use App\Models\Inventory\ExitNote;
use App\Models\Inventory\ExitNoteItem;

class ExitNoteManager extends Component
{
    public $products = [];
    public $exitNotes = [];
    public $product_id;
    public $exit_type;
    public $quantity;
    public $unit_price;
    public $reason;
    public $exit_date;

    public function mount()
    {
        // Cargar productos activos SIN relaciones automáticas
        $this->products = Product::without('category')
            ->active()
            ->orderBy('name')
            ->get(['id', 'name', 'stock']);

        // Cargar notas de salida con sus items y productos
        $this->exitNotes = ExitNote::with(['items.product:id,name', 'user:id,name'])
            ->latest()
            ->get();
    }

    public function save()
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
            'exit_type' => 'required|in:expired,damaged,company_use',
            'quantity' => 'required|numeric|min:0.01',
            'unit_price' => 'required|numeric|min:0',
        ]);

        // ✅ CALCULAR SUBTOTAL
        $subtotal = $this->quantity * $this->unit_price;

        // VALIDAR QUE HAY SUFICIENTE STOCK
        $product = Product::find($this->product_id);
        if ($product->stock < $this->quantity) {
            session()->flash('error', 'No hay suficiente stock disponible. Stock actual: ' . $product->stock);
            return;
        }

        // Crear la nota de salida
        $exitNote = ExitNote::create([
            'user_id' => auth()->id(),
            'exit_type' => $this->exit_type,
            'source' => 'manual',
            'reason' => $this->reason,
        ]);

        // Crear el item de la nota de salida
        ExitNoteItem::create([
            'exit_note_id' => $exitNote->id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,    // ← GUARDAR PRECIO
            'subtotal' => $subtotal,              // ← GUARDAR SUBTOTAL
            'reason' => $this->exit_type,
        ]);
        
        // DESCONTAR DEL INVENTARIO
        $product = Product::find($this->product_id);
        if ($product) {
            $product->decrement('stock', $this->quantity);
        }

        // Limpiar formulario
        $this->reset(['product_id', 'exit_type', 'quantity', 'unit_price', 'reason', 'exit_date']);

        // Recargar notas
        $this->exitNotes = ExitNote::with(['items.product:id,name', 'user:id,name'])
            ->latest()
            ->get();
        
        // Mensaje de éxito
        session()->flash('message', 'Nota de salida creada exitosamente.');

    }

    public function render()
    {
        return view('livewire.exit-notes.exit-note-manager');
    }
}