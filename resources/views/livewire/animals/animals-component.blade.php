
<div>
    <div class="container">
        @if ($isAdmin)
            {{-- Vista para ADMIN (Tabla) --}}
            <x-card cardTitle="Listado de Animales ({{ $this->totalRegistros }})">
                <x-slot:cardTools>
                    <a href="#" class="btn btn-primary" wire:click='create'>
                        <i class="fas fa-plus-circle"></i> Crear Animal
                    </a>
                </x-slot>

                <x-table>
                    <x-slot:thead>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Raza</th>
                        <th>Edad</th>
                        <th width="3%">Acciones</th>
                    </x-slot:thead>

                    @foreach ($animals as $animal) 
                    <tr>
                        <td>{{ $animal->id }}</td>
                        <td>
                            @if ($animal->image)
                                <img src="{{ $animal->image }}" alt="{{ $animal->name }}" class="w-8 h-8 object-cover rounded">
                            @else
                                <span class="text-gray-500">No hay imagen</span>
                            @endif
                        </td>
                        <td>{{ $animal->name }}</td>
                        <td>{{ $animal->race ?? 'N/A' }}</td>
                        <td>{{ $animal->age }} años</td>
                        <td>
                            <a href="#" wire:click='edit({{ $animal->id }})' title="Editar" class="btn btn-primary btn-sm">
                                <i class="far fa-edit"></i>
                            </a>
                            <a href="#" wire:click='delete({{ $animal->id }})' title="Eliminar" class="btn btn-danger btn-sm">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                
              
           
                
                </x-table>
                <div class="d-flex justify-content-center mt-4">
                    {!! $animals->links() !!} {{-- Usa {!! !!} en lugar de {{ }} para forzar la renderización --}}
                </div>
                <!-- Paginación -->
               
            </x-card>                
        @else
            {{-- Vista para USUARIO (Tarjetas en formato horizontal) --}}
            <x-card cardTitle="Lista de Animales">
                <div class="row">
                    @foreach ($animals as $animal)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <!-- Imagen del animal -->
                                @if ($animal->image)
                                    <img src="{{ $animal->image }}" alt="{{ $animal->name }}" class="card-img-top"
                                        style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-gray-200 d-flex align-items-center justify-content-center"
                                        style="height: 200px;">
                                        <span class="text-gray-500">No hay imagen</span>
                                    </div>
                                @endif

                                <!-- Detalles del animal -->
                                <div class="card-body">
                                    <h5 class="card-title">{{ $animal->name }}</h5>
                                    <p class="card-text"><strong>Raza:</strong> {{ $animal->race ?? 'N/A' }}</p>
                                    <p class="card-text"><strong>Edad:</strong> {{ $animal->age }} años</p>
                                    <p class="card-text"><strong>Estado:</strong> {{ ucfirst($animal->status) }}</p>
                                    <p class="card-text"><strong>Descripción:</strong>
                                        {{ Str::limit($animal->description, 50) }}</p>
                                    <button wire:click="viewAnimalDetails({{ $animal->id }})"
                                        class="btn btn-success btn-block">Ver Detalles</button>
                                        <button wire:click="openAdoptionModal({{ $animal->id }})" class="btn btn-primary">
                                            Adoptar
                                        </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {!! $animals->links() !!} {{-- Usa {!! !!} en lugar de {{ }} para forzar la renderización --}}
                </div>
            </x-card>
        @endif



        {{-- Modal para agregar o editar animales --}}

        <x-modal modalId="animalModal" modalTitle="{{ $Id == 0 ? 'Nuevo Animal' : 'Editar Animal' }}">
            <form wire:submit="{{ $Id == 0 ? 'store' : 'update' }}">
                <div class="d-flex flex-wrap mb-4">
                    <!-- Columna 1 (Izquierda) -->
                    <div class="form-group col-md-4 mb-4">
                        <label for="name">Nombre:</label>
                        <input wire:model="name" id="name" type="text" class="form-control"
                            placeholder="Nombre del Animal">
                        @error('name')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4 mb-4">
                        <label for="race">Raza:</label>
                        <input wire:model="race" id="race" type="text" class="form-control"
                            placeholder="Raza del Animal">
                        @error('race')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4 mb-4">
                        <label for="age">Edad:</label>
                        <input wire:model="age" id="age" type="number" class="form-control"
                            placeholder="Edad del Animal">
                        @error('age')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex flex-wrap mb-4">
                    <!-- Columna 2 (Derecha) -->
                    <div class="form-group col-md-4 mb-4">
                        <label for="sex">Sexo:</label>
                        <input wire:model="sex" id="sex" type="text" class="form-control"
                            placeholder="Masculino o Femenino">
                        @error('sex')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4 mb-4">
                        <label for="size">Tamaño:</label>
                        <input wire:model="size" id="size" type="text" class="form-control"
                            placeholder="Tamaño del Animal">
                        @error('size')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4 mb-4">
                        <label for="status">Estado:</label>
                        <input wire:model="status" id="status" type="text" class="form-control"
                            placeholder="Disponible o Adoptado">
                        @error('status')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group col-md-8 mb-4">
                    <label for="image">Imagen:</label>
                    <input wire:model="image" id="image" type="text" class="form-control"
                        placeholder="URL de la imagen">
                    @error('image')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-8 mb-4">
                    <label for="description">Descripción:</label>
                    <textarea wire:model="description" id="description" class="form-control" placeholder="Descripción del Animal"></textarea>
                    @error('description')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary float-right">
                    {{ $Id == 0 ? 'Guardar' : 'Actualizar' }}
                </button>
            </form>
        </x-modal>




       


        <x-modal modalId="animalDetailsModal" modalTitle="Detalles del Animal">
            <div>
                <strong>Nombre:</strong> {{ $name }}
            </div>
            <div>
                <strong>Raza:</strong> {{ $race }}
            </div>
            <div>
                <strong>Edad:</strong> {{ $age }}
            </div>
            <div>
                <strong>Sexo:</strong> {{ $sex }}
            </div>
            <div>
                <strong>Tamaño:</strong> {{ $size }}
            </div>
            <div>
                <strong>Descripción:</strong> {{ $description }}
            </div>
            <div>
                <strong>Estado:</strong> {{ $status }}
            </div>
            <div>
               
                <img src="{{ $image }}" alt="Imagen del animal" class="img-fluid">
            </div>
        </x-modal>










        <!-- Modal para solicitar adopción -->
<x-modal modalId="adoptionModal" modalTitle="Solicitud de Adopción">
    <form wire:submit.prevent="submitAdoptionRequest">
        <div class="form-group">
            <label for="preparation">¿Está preparado para cuidar al animal?</label>
            <textarea wire:model="preparation" id="preparation" class="form-control" placeholder="Explique por qué está preparado para cuidar al animal."></textarea>
            @error('preparation') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="experience">¿Tiene experiencia cuidando animales?</label>
            <textarea wire:model="experience" id="experience" class="form-control" placeholder="Explique su experiencia cuidando animales, si tiene alguna."></textarea>
            @error('experience') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="time">¿Cuánto tiempo podrá dedicar al animal diariamente?</label>
            <input wire:model="time" type="text" class="form-control" placeholder="Tiempo diario disponible (horas)">
            @error('time') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="adoption_reason">¿Por qué desea adoptar este animal?</label>
            <textarea wire:model="adoption_reason" id="adoption_reason" class="form-control" placeholder="Razones para querer adoptar a este animal."></textarea>
            @error('adoption_reason') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary float-right">
            Enviar Solicitud
        </button>
    </form>
</x-modal>

    </div>
</div>