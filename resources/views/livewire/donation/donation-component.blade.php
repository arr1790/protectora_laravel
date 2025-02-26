<div class="container mt-4">
    <h1 class="text-center mb-4">Donaciones</h1>

    @if($isAdmin) 
        <!-- Vista para administrador: Listado de Donaciones -->
        <h2 class="text-center">Listado de Donaciones</h2>
        <div class="row">
            @if($donation->isEmpty()) 
                <p class="text-center">No hay donaciones disponibles.</p>
            @else
                @foreach($donation as $don)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $don->name }}</h5>
                                <p class="card-text">
                                    <strong>Importe:</strong> €{{ number_format($don->amount, 2) }} <br>
                                    <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($don->date_donation)->format('d/m/Y') }} <br>
                                    <strong>Donado por:</strong> {{ $don->user->name }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $donation->links() }}
        </div>
    @else
        <!-- Vista para usuario normal: Formulario de Donación -->
        <h2 class="text-center">Realizar Donación</h2>
        <form wire:submit.prevent="store">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" wire:model="name" class="form-control" required>
                @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="amount">Importe (€)</label>
                <input type="number" id="amount" wire:model="amount" class="form-control" required>
                @error('amount')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3">Donar</button>
        </form>
    @endif

    <!-- Mensaje de éxito -->
    @if(session()->has('success'))
        <div class="alert alert-success mt-4">
            {{ session('success') }}
        </div>
    @endif
</div>
