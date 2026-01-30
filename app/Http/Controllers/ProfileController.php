<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        /*
        Este código es una redirección en Laravel, un popular framework de PHP. La función Redirect::route() redirige 
        al usuario a una ruta específica en la aplicación. En este caso, la ruta se llama profile.edit. 

        La función with() agrega un mensaje flash a la sesión actual del usuario. Un mensaje flash es un mensaje que 
        se muestra al usuario una vez y luego se elimina de la sesión. En este caso, el mensaje flash se llama status 
        y su valor es profile-updated. Esto significa que después de que el usuario sea redirigido a la ruta profile.edit, 
        se mostrará un mensaje que indica que el perfil ha sido actualizado. 

        Entonces, en resumen, este código redirige al usuario a la página de edición de perfil y muestra un mensaje flash 
        que indica que el perfil ha sido actualizado.
        */
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
