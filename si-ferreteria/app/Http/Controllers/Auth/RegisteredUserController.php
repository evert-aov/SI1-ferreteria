<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\User_security\User;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'document_type' => ['required', 'in:CI,NIT,PASSPORT'],
            'document_number' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'gender' => ['required', 'in:male,female'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'status' => true,
        ]);

        $roleCliente = Role::where('name', 'Cliente')->first();

        if ($roleCliente) {
            $user->roles()->attach($roleCliente->id, [
                'assigned_date' => now(),
                'expiration_date' => null,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
