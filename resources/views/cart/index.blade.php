@extends('layouts.app')

@section('auth')
<div class="container py-5">
    <h2 class="text-center mb-4">Mi Carrito</h2>

    @if(session()->has('cart') && count(session()->get('cart')) > 0)
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Imagen</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(session()->get('cart') as $productId => $details)
                        <tr>
                            <!-- Imagen del producto -->
                            <td>
                                <img src="{{ (filter_var($details['image'], FILTER_VALIDATE_URL)) ? $details['image'] : asset('images/'.$details['image'] ?? 'default-image.jpg') }}" 
                                     alt="{{ $details['name'] }}" 
                                     class="img-fluid" 
                                     style="width: 50px; height: 50px; object-fit: cover;">
                            </td>

                            <!-- Nombre del producto -->
                            <td>{{ $details['name'] }}</td>

                            <!-- Cantidad -->
                            <td>
                                <form action="{{ route('cart.update', $productId) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('POST')
                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" style="width: 60px;" readonly>
                                </form>
                            </td>

                            <!-- Precio -->
                            <td>{{ number_format($details['price'], 2) }}€</td>

                            <!-- Total por producto -->
                            <td>{{ number_format($details['price'] * $details['quantity'], 2) }}€</td>

                            <!-- Botones de acciones -->
                            <td>
                                <!-- Botón para añadir más cantidad -->
                                <a href="{{ route('cart.addMore', $productId) }}" class="btn btn-success btn-sm p-1">Añadir Más</a>
                            
                                <!-- Botón para reducir cantidad -->
                                <a href="{{ route('cart.removeMore', $productId) }}" class="btn btn-warning btn-sm p-1">Reducir Cantidad</a>
                            
                                <!-- Botón para eliminar -->
                                <a href="{{ route('cart.remove', $productId) }}" class="btn btn-danger btn-sm p-1">Eliminar</a>
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total del carrito -->
        <div class="text-right mb-4">
            <h4>Total: 
                {{ number_format(array_sum(array_map(function($item) {
                    return $item['price'] * $item['quantity'];
                }, session()->get('cart'))), 2) }}€
            </h4>
        </div>

        <!-- Botones de acción -->
        <div class="d-flex justify-content-between">
            <!-- Botón para seguir comprando -->
            <a href="{{ route('products') }}" class="btn btn-secondary">Seguir Comprando</a>

            <!-- Botón para finalizar compra -->
            <a href="{{ route('cart.checkout') }}" class="btn btn-primary">Finalizar Compra</a>
        </div>

    @else
        <p class="text-center">No tienes productos en el carrito.</p>
    @endif
</div>
@endsection
