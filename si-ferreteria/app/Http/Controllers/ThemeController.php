<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function setTheme(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:light,dark',
        ]);

        // Guardar la preferencia en la sesión
        session(['theme' => $request->theme]);

        return response()->json(['success' => true]);
    }
}
