@extends('layouts.app')

@section('auth')
<div class="container py-5">
    <h2 class="text-center mb-4">Resumen de la Compra</h2>

    @if(session()->has('cart') && count(session()->get('cart')) > 0)
        <!-- Métodos de pago (mostrados arriba) -->
        <div class="d-flex justify-content-center mb-4">
            <img src="{{ asset('assets/img/bizum.png') }}" alt="Bizum" class="img-fluid" style="width: 50px; height: auto; margin: 0 10px;">
            <img src="{{ asset('assets/img/paypal.png') }}" alt="PayPal" class="img-fluid" style="width: 50px; height: auto; margin: 0 10px;">
            <img src="{{ asset('assets/img/visa.png') }}" alt="VISA" class="img-fluid" style="width: 50px; height: auto; margin: 0 10px;">
            <img src="{{ asset('assets/img/mcommerce.png') }}" alt="MCommerce" class="img-fluid" style="width: 50px; height: auto; margin: 0 10px;">
        </div>

        <!-- Formulario para seleccionar método de pago -->
        <form action="{{ route('cart.processPayment') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="paymentMethod"><strong>Selecciona un método de pago:</strong></label>
                <select name="paymentMethod" id="paymentMethod" class="form-control" required>
                    <option value="bizum">Bizum</option>
                    <option value="paypal">PayPal</option>
                    <option value="visa">VISA</option>
                    <option value="mcommerce">MCommerce</option>
                </select>
            </div>
        
            <!-- Botón de pago -->
            <button type="submit" class="btn btn-success">Pagar</button>
        </form>

        <!-- Detalles del carrito de compra -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Imagen</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                        $shipping = 0; // Precio de envío (Gratis en este caso)
                    @endphp
                    @foreach(session()->get('cart') as $productId => $details)
                        @php
                            $total += $details['price'] * $details['quantity'];
                        @endphp
                        <tr>
                            <td>
                                <img src="{{ (filter_var($details['image'], FILTER_VALIDATE_URL)) ? $details['image'] : asset('images/'.$details['image'] ?? 'default-image.jpg') }}" 
                                     alt="{{ $details['name'] }}" 
                                     class="img-fluid" 
                                     style="width: 50px; height: 50px; object-fit: cover;">
                            </td>
                            <td>{{ $details['name'] }}</td>
                            <td>{{ $details['quantity'] }}</td>
                            <td>{{ number_format($details['price'], 2) }}€</td>
                            <td>{{ number_format($details['price'] * $details['quantity'], 2) }}€</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Detalles del precio -->
        <div class="d-flex justify-content-between mb-4">
            <p><strong>Sub Total:</strong> {{ number_format($total, 2) }}€</p>
        </div>

        <!-- Transporte -->
        <div class="d-flex justify-content-between mb-4">
            <p><strong>Transporte:</strong> Gratis</p>
        </div>

        <!-- Total -->
        <div class="d-flex justify-content-between mb-4">
            <h4><strong>Total (impuestos inc.):</strong> {{ number_format($total + $shipping, 2) }}€</h4>
        </div>

        <!-- Botones de acción -->
        <div class="d-flex justify-content-between">
            <a href="{{ route('cart.index') }}" class="btn btn-secondary">Volver al Carrito</a>
        </div>

    @elseif(session('success'))
        <!-- Mostrar mensaje de éxito -->
        <div class="alert alert-success text-center">
            <h4>{{ session('success') }}</h4>
        </div>

        <!-- Botón para volver al inicio -->
        <div class="text-center">
            <a href="{{ route('home') }}" class="btn btn-primary">Volver al Inicio</a>
        </div>

    @else
        <p class="text-center">No tienes productos en el carrito.</p>
    @endif
</div>

@endsection
