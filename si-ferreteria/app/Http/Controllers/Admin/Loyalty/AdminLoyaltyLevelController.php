<?php

namespace App\Http\Controllers\Admin\Loyalty;

use App\Http\Controllers\Controller;
use App\Models\Loyalty\LoyaltyLevel;
use Illuminate\Http\Request;

class AdminLoyaltyLevelController extends Controller
{
    /**
     * Mostrar lista de niveles
     */
    public function index()
    {
        $levels = LoyaltyLevel::ordered()->get();
        
        return view('admin.loyalty.levels.index', compact('levels'));
    }

    /**
     * Mostrar formulario para crear nivel
     */
    public function create()
    {
        return view('admin.loyalty.levels.form', [
            'level' => null,
            'isEdit' => false,
        ]);
    }

    /**
     * Guardar nuevo nivel
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:loyalty_levels,code|regex:/^[a-z_]+$/',
            'name' => 'required|string|max:255',
            'min_points' => 'required|integer|min:0',
            'multiplier' => 'required|numeric|min:1|max:10',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:10',
            'is_active' => 'boolean',
        ]);

        // Obtener el siguiente orden
        $maxOrder = LoyaltyLevel::max('order') ?? 0;
        $validated['order'] = $maxOrder + 1;
        $validated['is_active'] = $request->has('is_active');

        LoyaltyLevel::create($validated);

        return redirect()
            ->route('admin.loyalty.levels.index')
            ->with('success', 'Nivel creado exitosamente');
    }

    /**
     * Mostrar formulario para editar nivel
     */
    public function edit(LoyaltyLevel $level)
    {
        return view('admin.loyalty.levels.form', [
            'level' => $level,
            'isEdit' => true,
        ]);
    }

    /**
     * Actualizar nivel
     */
    public function update(Request $request, LoyaltyLevel $level)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|regex:/^[a-z_]+$/|unique:loyalty_levels,code,' . $level->id,
            'name' => 'required|string|max:255',
            'min_points' => 'required|integer|min:0',
            'multiplier' => 'required|numeric|min:1|max:10',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:10',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $level->update($validated);

        return redirect()
            ->route('admin.loyalty.levels.index')
            ->with('success', 'Nivel actualizado exitosamente');
    }

    /**
     * Eliminar nivel
     */
    public function destroy(LoyaltyLevel $level)
    {
        // Verificar que no tenga cuentas asociadas
        if ($level->accounts()->count() > 0) {
            return redirect()
                ->route('admin.loyalty.levels.index')
                ->with('error', 'No se puede eliminar un nivel con cuentas asociadas');
        }

        $level->delete();

        return redirect()
            ->route('admin.loyalty.levels.index')
            ->with('success', 'Nivel eliminado exitosamente');
    }

    /**
     * Reordenar niveles
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'levels' => 'required|array',
            'levels.*' => 'required|integer|exists:loyalty_levels,id',
        ]);

        foreach ($validated['levels'] as $order => $levelId) {
            LoyaltyLevel::where('id', $levelId)->update(['order' => $order + 1]);
        }

        return response()->json(['success' => true]);
    }
}
