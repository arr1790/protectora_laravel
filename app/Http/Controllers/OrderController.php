<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.user_type.auth')] 
class OrderController extends Controller
{
    // Mostrar todos los pedidos del usuario autenticado o todos los pedidos si es administrador
    public function index()
    {
        if (Auth::user()->type == 1) {
            $orders = Order::with('products')->get();  // Todos los pedidos para administradores
        } else {
            $orders = Order::where('user_id', Auth::id())->with('products')->get(); // Solo los pedidos del usuario autenticado
        }
        
        return view('orders.index', compact('orders'));
    }

    // Crear un nuevo pedido
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        // Calcular el total del pedido
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Crear el pedido
        $order = Order::create([
            'user_id' => Auth::id(),
            'status'  => 'pendiente',  // Estado inicial del pedido
            'total'   => $total,
        ]);

        // Asociar los productos al pedido
        foreach ($cart as $productId => $details) {
            $order->products()->attach($productId, [
                'quantity' => $details['quantity'],
                'price'    => $details['price'],
            ]);
        }

        // Vaciar el carrito después de realizar el pedido
        session()->forget('cart');

        return redirect()->route('orders.index')->with('success', 'Pedido realizado con éxito.');
    }

    // Mostrar los detalles de un pedido específico
    public function show(Order $order)
    {
        // Verificar si el pedido pertenece al usuario autenticado o si es un administrador
        if (Auth::user()->type != 1 && Auth::id() != $order->user_id) {
            return redirect()->route('orders.index')->with('error', 'Acceso denegado.');
        }

        // Cargar los productos asociados al pedido
        $order->load('products');

        return view('orders.show', compact('order'));
    }





    // Acción para actualizar el estado del pedido
    public function updateStatus(Request $request, Order $order)
    {
        // Validación del estado
        $request->validate([
            'status' => 'required|in:pendiente,completado,cancelado',
        ]);

        // Actualizamos el estado del pedido
        $order->status = $request->status;

        // Si el estado es "completado", eliminamos el pedido
        if ($order->status == 'completado') {
            // Eliminar el pedido de la base de datos
            $order->delete();
            return redirect()->route('orders.index')->with('success', 'El pedido ha sido completado y eliminado');
        }

        // Si el estado no es "completado", guardamos el cambio de estado
        $order->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('orders.index')->with('success', 'Estado del pedido actualizado');
    }
}
