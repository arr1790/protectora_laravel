@extends('layouts.app')

@section('auth')
<div class="container py-5">
    <h2 class="text-center mb-5">Detalles del Pedido #{{ $order->id }}</h2>

    <div class="row">
        <!-- Información del Pedido -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Información del Pedido</h4>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><strong>Usuario:</strong> {{ $order->user->name }}</li>
                        <li><strong>Fecha:</strong> {{ $order->created_at->format('d-m-Y') }}</li>
                        <li><strong>Total:</strong> €{{ number_format($order->total, 2) }}</li>
                        <li><strong>Estado:</strong> 
                            <span class="badge 
                                @if($order->status == 'pendiente') badge-warning 
                                @elseif($order->status == 'completado') badge-success 
                                @else badge-secondary @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Productos del Pedido -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Productos en este Pedido</h4>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        @foreach ($order->products as $product)
                            <li>
                                <strong>{{ $product->name }}</strong> - 
                                {{ $product->pivot->quantity }} x €{{ number_format($product->pivot->price, 2) }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón Volver -->
    <div class="text-center mt-4">
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Volver a Mis Pedidos</a>
    </div>
</div>
@endsection
