<div> <!-- Contenedor raíz del componente -->

    <div class="container mt-4">
        <h1 class="text-center mb-4">Apadrinamiento de Animales</h1>

        @if($isAdmin) 
            <!-- Vista para administrador: Listado de Padrinos -->
            <h2 class="text-center">Listado de Padrinos</h2>
            <div class="row">
                @if(isset($haztePadrino) && $haztePadrino->isEmpty()) 
                    <p class="text-center">No hay padrinos disponibles.</p>
                @else
                    @foreach($haztePadrino as $padrino)
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $padrino->name }} {{ $padrino->surname }}</h5>
                                    <p class="card-text">
                                        <strong>Animal Apadrinado:</strong> {{ $padrino->animal->name ?? 'No asignado' }} <br>
                                        <strong>Fecha de Apadrinamiento:</strong> {{ \Carbon\Carbon::parse($padrino->date_apadrinamiento)->format('d/m/Y') }} <br>

                                        @if($padrino->user)
                                            <strong>Apadrinado por:</strong> {{ $padrino->user->name }} <br>
                                        @else
                                            <strong>Apadrinado por:</strong> Usuario no encontrado <br>
                                        @endif

                                        <strong>Correo Electrónico:</strong> {{ $padrino->email }} <br>
                                        <strong>Dirección:</strong> {{ $padrino->address }} <br>
                                        <strong>Ciudad:</strong> {{ $padrino->city }} <br>
                                        <strong>DNI:</strong> {{ $padrino->dni }} <br>
                                        <strong>Teléfono:</strong> {{ $padrino->phone }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-3">
                {{ $haztePadrino->links() }} <!-- Muestra los links de paginación -->
            </div>
        @else
            <!-- Vista para usuario normal: Formulario de Apadrinamiento -->
            <h2 class="text-center">Realizar Apadrinamiento</h2>
            <form wire:submit.prevent="store">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" id="name" wire:model="name" class="form-control" placeholder="Ingrese su nombre" required>
                    @error('name')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="surname">Apellido</label>
                    <input type="text" id="surname" wire:model="surname" class="form-control" placeholder="Ingrese su apellido" required>
                    @error('surname')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address">Dirección</label>
                    <input type="text" id="address" wire:model="address" class="form-control" placeholder="Ingrese su dirección" required>
                    @error('address')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="city">Ciudad</label>
                    <input type="text" id="city" wire:model="city" class="form-control" placeholder="Ingrese su ciudad" required>
                    @error('city')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input type="text" id="dni" wire:model="dni" class="form-control" placeholder="Ingrese su DNI" required>
                    @error('dni')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Teléfono</label>
                    <input type="text" id="phone" wire:model="phone" class="form-control" placeholder="Ingrese su teléfono" required>
                    @error('phone')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" wire:model="email" class="form-control" placeholder="Ingrese su correo electrónico" required>
                    @error('email')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="animal_id">Seleccionar Animal</label>

                    @if(isset($animalItems) && $animalItems instanceof \Illuminate\Support\Collection && !$animalItems->isEmpty())
                        <select id="animal_id" wire:model="animal_id" class="form-control" required>
                            <option value="">Selecciona un animal</option>
                            @foreach($animalItems as $animal)
                                <option value="{{ $animal->id }}">{{ $animal->name }}</option>
                            @endforeach
                        </select>
                    @else
                        <p>No hay animales disponibles para apadrinar.</p>
                    @endif

                    @error('animal_id')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mt-3">Apadrinar</button>
            </form>
        @endif

        <!-- Mensaje de éxito -->
        @if(session()->has('success'))
            <div class="alert alert-success mt-4">
                {{ session('success') }}
            </div>
        @endif
    </div>

</div> <!-- Cierra el contenedor raíz -->
