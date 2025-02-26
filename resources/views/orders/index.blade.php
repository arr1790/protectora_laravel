@extends('layouts.app')

@section('auth')
<div class="container py-5">
    <h2 class="text-center mb-5">Mis Pedidos</h2>

    @if($orders->isEmpty())
        <div class="alert alert-warning text-center" role="alert">
            No tienes pedidos disponibles.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover shadow-lg">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID de Pedido</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Total</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td class="text-center">{{ $order->id }}</td>
                            <td class="text-center">{{ $order->user->name }}</td>
                            <td class="text-center">{{ $order->created_at->format('d-m-Y') }}</td>
                            <td class="text-center">{{ number_format($order->total, 2) }}€</td>
                            <td class="text-center">
                                <!-- Formulario para cambiar el estado -->
                                <form action="{{ route('orders.updateStatus', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select">
                                        <option value="pendiente" {{ $order->status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="completado" {{ $order->status == 'completado' ? 'selected' : '' }}>Completado</option>
                                        <option value="cancelado" {{ $order->status == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary mt-2">Actualizar</button>
                                </form>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-info btn-sm">Ver Detalles</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
     <!-- Botón para volver atrás -->
     <div class="text-center mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Volver al Inicio</a>
    </div>
</div>
@endsection
