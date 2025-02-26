<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Livewire\Animals\AnimalsComponent;
use App\Livewire\Donation\DonationComponent;
use App\Livewire\HaztePadrino\HaztePadrinoComponent;
use App\Livewire\Products\ProductsComponent;
use App\Livewire\Volunteer\VolunteerComponent;
use Illuminate\Support\Facades\Route;

// Rutas que requieren autenticación
Route::group(['middleware' => 'auth'], function () {

    // Ruta para la página principal
    Route::get('/', [HomeController::class, 'home'])->name('home');

    // Ruta para el dashboard (dependiendo del rol del usuario)
    Route::get('dashboard', function () {
        if (auth()->user()->type == 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return view('dashboard');
        }
    })->name('dashboard');

    // Rutas para componentes con autenticación
    Route::get('/animals', AnimalsComponent::class)->name('animals');
    Route::get('/donation', DonationComponent::class)->name('donation');
    Route::get('/hazte-padrino', HaztePadrinoComponent::class)->name('hazte-padrino');
    Route::get('/volunteer', VolunteerComponent::class)->name('volunteers');
    Route::get('/products', ProductsComponent::class)->name('products');

    // Rutas del carrito
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::get('/add/{id}', [CartController::class, 'addToCart'])->name('add');
        Route::post('/update/{id}', [CartController::class, 'updateCart'])->name('update');
        Route::get('/remove/{id}', [CartController::class, 'removeFromCart'])->name('remove');
        Route::get('/clear', [CartController::class, 'clearCart'])->name('clear');
        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
        
        // Ruta para reducir la cantidad de un producto en el carrito
        Route::get('/remove-more/{id}', [CartController::class, 'removeMore'])->name('removeMore');
    
        // Ruta para procesar el pago con método POST
        Route::post('/process-payment', [CartController::class, 'processPayment'])->name('processPayment');
        Route::get('/confirm', [CartController::class, 'confirm'])->name('confirm');
    
        // Rutas adicionales
        Route::get('/continue', [CartController::class, 'continueShopping'])->name('continue');
        Route::get('/add-more/{id}', [CartController::class, 'addMore'])->name('addMore');
    });
    

    // Rutas de pedido

Route::middleware('auth')->group(function () {
    // Mostrar los pedidos del usuario autenticado
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    // Mostrar el detalle de un pedido (para el usuario o admin)
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    // Crear un nuevo pedido
    Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
    Route::patch('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});



    // Ruta de cierre de sesión
    Route::get('/logout', [SessionsController::class, 'destroy'])->name('logout');

    // Ruta para editar perfil del usuario
    Route::get('/user-profile', [InfoUserController::class, 'create'])->name('user-profile');
    Route::post('/user-profile', [InfoUserController::class, 'store']);
});

// Rutas públicas (para usuarios invitados)
Route::group(['middleware' => 'guest'], function () {
    // Ruta para registro de usuario
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    // Rutas para inicio de sesión
    Route::get('/login', [SessionsController::class, 'create'])->name('login');
    Route::post('/session', [SessionsController::class, 'store']);

    // Rutas para la recuperación de contraseña
    Route::get('/login/forgot-password', [ResetController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
    Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
    Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});

// Rutas de administrador (solo accesibles por usuarios con rol admin)
Route::group(['middleware' => 'admin'], function () {
    Route::get('admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});
