<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;



#[Layout('layouts.user_type.auth')]  

class CartController extends Controller
{
   
    public function index()
    {

        $products = Product::all(); 
        return view('cart.index', compact('products'));
    }


    public function addToCart($id)
    {

        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('home')->with('error', 'Producto no encontrado');
        }


        $cart = session()->get('cart', []);

      
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
          
            $cart[$id] = [
                'name' => $product->name,
                'description' => $product->description ?? 'Descripción no disponible',
                'price' => $product->price,
                'image' => $product->image ?? 'images/default-image.jpg',
                'quantity' => 1,
            ];
        }

       
        session()->put('cart', $cart);

       
        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }


    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

       
        $cart = session()->get('cart', []);

    
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);

            return redirect()->route('cart.index')->with('success', 'Cantidad actualizada');
        }

        return redirect()->route('cart.index')->with('error', 'Producto no encontrado en el carrito');
    }

  
    public function removeFromCart($id)
    {
        
        $cart = session()->get('cart', []);

        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Producto eliminado del carrito');
        }

        return redirect()->route('cart.index')->with('error', 'Producto no encontrado en el carrito');
    }

  
    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Carrito vaciado');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.checkout', compact('cart', 'total'));
    }


  

        

        public function confirm()
        {
            return view('cart.confirm');
        }
        
    

    public function continueShopping()
    {

        return redirect()->route('products');
    }

    public function addMore($id)
    {

        $cart = session()->get('cart', []);


        if (isset($cart[$id])) {

            $cart[$id]['quantity']++;


            session()->put('cart', $cart);
        }


        return redirect()->route('cart.index')->with('success', 'Cantidad aumentada');
    }



   // CartController.php


   public function processPayment(Request $request)
   {
       // Simulación del proceso de pago (puedes reemplazar esto con la integración real de pago)
       $paymentSuccessful = $this->simulatePayment();
   
       if ($paymentSuccessful) {
           // Obtener los productos del carrito
           $cart = session()->get('cart');
           $products = [];
   
           foreach ($cart as $productId => $details) {
               $products[] = [
                   'product_id' => $productId,
                   'quantity' => $details['quantity'],
                   'price' => $details['price']
               ];
           }
   
           // Crear el pedido
           $order = Order::create([
               'user_id' => Auth::id(),  // El ID del usuario autenticado
               'total' => array_sum(array_map(function($item) {
                   return $item['price'] * $item['quantity'];
               }, $products)),  // Calculamos el total
               'status' => 'pendiente',  // El estado inicial del pedido
           ]);
   
           // Asignar los productos al pedido usando la tabla intermedia 'order_product'
           foreach ($products as $product) {
               $order->products()->attach($product['product_id'], [
                   'quantity' => $product['quantity'],
                   'price' => $product['price']
               ]);
           }
   
           // Vaciar el carrito después de completar el pedido
           session()->forget('cart');
   
           // Redirigir a la página de confirmación con el mensaje
           return redirect()->route('cart.confirm')->with('success', '¡Pago realizado con éxito! Tu pedido está en proceso.');
       } else {
           // Si el pago falla, redirigir de nuevo al carrito con un mensaje de error
           return redirect()->route('cart.index')->with('error', 'Error en el pago. Inténtalo nuevamente.');
       }
   }
   

   
   
   public function simulatePayment()
   {
       // Simulación de pago: devuelve true o false aleatoriamente
       return rand(0, 1) === 1;
   }
   
   public function removeMore($id)
   {
       $cart = session()->get('cart', []);
   
       // Verificar si el producto existe en el carrito
       if (isset($cart[$id])) {
           if ($cart[$id]['quantity'] > 1) {
               // Reducir la cantidad en 1
               $cart[$id]['quantity']--;
           } else {
               // Si la cantidad es 1, eliminar el producto del carrito
               unset($cart[$id]);
           }
   
           // Actualizar el carrito en la sesión
           session()->put('cart', $cart);
       }
   
       // Redirigir al carrito después de actualizar
       return redirect()->route('cart.index')->with('success', 'Cantidad reducida con éxito.');
   }
}   