<div>
    @if ($isAdmin)
        <!--  VISTA PARA ADMINISTRADORES (TABLA) -->
        <x-card cardTitle="Listado de Productos ( {{ $totalRegistros }} )">
            <x-slot:cardTools>
                <a href="#" class="btn btn-primary" wire:click="create">
                    <i class="fas fa-plus-circle"></i> Crear Producto
                </a>
            </x-slot>

            <x-table>
                <x-slot:thead>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th width="3%">Acciones</th>
                </x-slot:thead>

                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td><img src="{{ $product->image }}" alt="{{ $product->name }}" width="50"></td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ number_format($product->price, 2) }}€</td>
                        <td>
                            <a href="#" wire:click="edit({{ $product->id }})" class="btn btn-primary btn-sm">
                                <i class="far fa-edit"></i>
                            </a>
                            <a href="#" wire:click="delete({{ $product->id }})" class="btn btn-danger btn-sm">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <td colspan="6">No hay productos registrados</td>
                    </tr>
                @endforelse
            </x-table>

     
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
      
        </x-card>
    @else
        <!-- VISTA PARA USUARIOS NORMALES (TARJETAS) -->
        <div class="row">
            <h1 class="text-center"> <i class="fas fa-shopping-cart" style="color: grey;"></i> Lista de Productos</h1>
            <p>Cada uno de estos productos tiene un propósito especial: ayudar a recaudar fondos para los animales que
                más lo necesitan. El dinero recaudado se destina a cubrir sus necesidades básicas, como alimento,
                medicamentos y cuidados veterinarios, asegurando que reciban todo lo que necesitan para vivir de manera
                saludable y feliz.</p>

            @forelse ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <p class="card-text font-weight-bold">{{ number_format($product->price, 2) }}€</p>
                            <!-- Botón para abrir el modal -->
                            <a href="{{ route('cart.add', $product->id) }}" class="btn btn-success">
                                Comprar
                            </a>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>No hay productos disponibles.</p>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    @endif

    <!-- Modal para crear o editar productos solo para admin -->
    @if ($isAdmin)
        <x-modal modalId="modalProducts" modalTitle="{{ $Id == 0 ? 'Crear Producto' : 'Editar Producto' }}">
            <form wire:submit="{{ $Id == 0 ? 'store' : 'update' }}">
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input wire:model="name" id="name" type="text" class="form-control"
                        placeholder="Nombre del Producto">
                    @error('name')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">Precio:</label>
                    <input wire:model="price" id="price" type="text" class="form-control"
                        placeholder="Precio del Producto">
                    @error('price')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image">Imagen:</label>
                    <input wire:model="image" id="image" type="text" class="form-control"
                        placeholder="URL de la imagen">
                    @error('image')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Descripción:</label>
                    <textarea wire:model="description" id="description" class="form-control" placeholder="Descripción del Producto"></textarea>
                    @error('description')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary float-right">
                    {{ $Id == 0 ? 'Guardar' : 'Actualizar' }}
                </button>
            </form>
        </x-modal>
    @endif
</div>
