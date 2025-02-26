@extends('layouts.app')

@section('auth')
<div class="container py-5">
    <h2 class="text-center mb-4">Confirmación del Pago</h2>

    @if(session('success'))
        <p class="text-center">{{ session('success') }}</p>
    @endif

    
    @if(session('total'))
        <p class="text-center">Total: {{ number_format(session('total'), 2) }}€</p>
    @endif

   
    <div class="text-center">
        <a href="{{ route('home') }}" class="btn btn-primary">Volver al Inicio</a>
    </div>
</div>
@endsection
