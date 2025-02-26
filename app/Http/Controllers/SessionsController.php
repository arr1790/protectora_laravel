<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

    
    class SessionsController extends Controller
    {
        // Mostrar la vista de login
        public function create()
        {
            return view('session.login-session');
        }
    
        // Función para manejar el login del usuario
        public function store()
        {
            // Validación de los campos de login
            $attributes = request()->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
    
            // Intentar iniciar sesión con las credenciales
            if (Auth::attempt($attributes)) {
                // Regenerar la sesión para evitar secuestro de sesión
                session()->regenerate();
    
                // Verificar el tipo de usuario ('admin' o 'user')
                if (Auth::user()->type == 'admin') {
                    // Si el usuario es admin, redirigir al panel de administración
                    return redirect('admin/dashboard')->with(['success' => 'Welcome, Admin!']);
                } else {
                    // Si el usuario es un usuario normal, redirigir al dashboard normal
                    return redirect('dashboard')->with(['success' => 'You are logged in.']);
                }
            } else {
                // Si las credenciales no son correctas, redirigir de vuelta con un mensaje de error
                return back()->withErrors(['email' => 'Email or password invalid.']);
            }
        }
    
        // Función para cerrar sesión
        public function destroy()
        {
            // Realizar logout del usuario
            Auth::logout();
    
            // Redirigir al login con un mensaje de éxito
            return redirect('/login')->with(['success' => 'You\'ve been logged out.']);
        }
    }
    