<div> <!-- Contenedor raíz del componente -->

    <div class="container mt-4">
        <h1 class="text-center mb-4">Voluntariado</h1>

        @if($isAdmin) 
            <!-- Vista para administrador: Listado de Voluntarios -->
            <h2 class="text-center">Listado de Voluntarios</h2>
            <div class="row">
                @if($volunteers->isEmpty()) 
                    <p class="text-center">No hay voluntarios disponibles.</p>
                @else
                    @foreach($volunteers as $volunteer)
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $volunteer->name }} {{ $volunteer->surname }}</h5>
                                    <p class="card-text">
                                        <strong>Teléfono:</strong> {{ $volunteer->phone }} <br>
                                        <strong>Fecha de Voluntariado:</strong> {{ \Carbon\Carbon::parse($volunteer->date_volunteers)->format('d/m/Y') }} <br>
                                        <strong>Tarea:</strong> {{ $volunteer->task }} <br>
                                        <strong>Horas Semanales:</strong> {{ $volunteer->weekly_hours }} <br>

                                        @if($volunteer->user)
                                            <strong>Voluntariado por:</strong> {{ $volunteer->user->name }} <br>
                                        @else
                                            <strong>Voluntariado por:</strong> Usuario no encontrado <br>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-3">
                {{ $volunteers->links() }} <!-- Muestra los links de paginación -->
            </div>
        @else
            <!-- Vista para usuario normal: Formulario de Voluntariado -->
            <h2 class="text-center">Unirse como Voluntario</h2>
            <form wire:submit.prevent="store">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" id="name" wire:model="name" class="form-control" required>
                    @error('name')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="surname">Apellido</label>
                    <input type="text" id="surname" wire:model="surname" class="form-control" required>
                    @error('surname')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Teléfono</label>
                    <input type="text" id="phone" wire:model="phone" class="form-control" required>
                    @error('phone')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="date_volunteers">Fecha de Voluntariado</label>
                    <input type="date" id="date_volunteers" wire:model="date_volunteers" class="form-control" required>
                    @error('date_volunteers')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="task">Tarea</label>
                    <select id="task" wire:model="task" class="form-control" required>
                        <option value="redes sociales">Redes Sociales</option>
                        <option value="limpieza">Limpieza</option>
                        <option value="mantenimiento">Mantenimiento</option>
                    </select>
                    @error('task')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="weekly_hours">Horas Semanales</label>
                    <select id="weekly_hours" wire:model="weekly_hours" class="form-control" required>
                        <option value="5">5 horas</option>
                        <option value="10">10 horas</option>
                        <option value="15">15 horas</option>
                        <option value="20">20 horas</option>
                    </select>
                    @error('weekly_hours')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-3">Unirse como Voluntario</button>
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
