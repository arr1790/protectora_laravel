@extends('layouts.app')

@section('auth')
<div id="app-root"> {{-- Contenedor raíz global --}}
    @if(\Request::is('static-sign-up')) 
        @include('layouts.navbars.guest.nav')
        <div>
            
            @if (isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </div>
        @include('layouts.footers.guest.footer')
    
    @elseif (\Request::is('static-sign-in')) 
        @include('layouts.navbars.guest.nav')
        <div>
            @if (isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </div>
        @include('layouts.footers.guest.footer')
    
    @else
        @include('layouts.navbars.auth.sidebar')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
            @include('layouts.navbars.auth.nav')
            <div class="container-fluid py-4">
                <div>
                    {{-- Mostrar $slot si es Livewire, y @yield si es una vista normal --}}
                    @if (isset($slot))
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endif
                </div>
                @include('layouts.footers.auth.footer')
            </div>
        </main>
        @include('components.fixed-plugin')
    @endif
</div>
@endsection

{{-- Agregamos los scripts antes de cerrar el body --}}
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@livewireScripts
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Escuchar el evento 'openModal' para abrir el modal
        window.addEventListener('openModal', event => {
            const modalId = event.detail.modalId;
            const modalElement = document.getElementById(modalId);
            if (modalElement) {
                $(modalElement).modal('show'); // Usamos jQuery para abrir el modal de Bootstrap
            }
        });

        // Escuchar el evento 'closeModal' para cerrar el modal
        Livewire.on('closeModal', () => {
            $('#modalProducts').modal('hide'); // Cierra el modal usando jQuery
        });
    });
    $(document).ready(function() {
        // Cuando se haga clic en "Comprar"
        $('.add-to-cart').click(function() {
            var productId = $(this).data('id');  // Obtener el ID del producto
            var url = '/cart/add/' + productId;  // URL de la ruta para agregar el producto al carrito

            // Realizar la solicitud AJAX
            $.get(url, function(response) {
                if(response.success) {
                    // Si la solicitud fue exitosa, actualizamos el contador en el navbar
                    $('#cart-count').text(response.cartCount);  // Actualizamos el número en el navbar
                } else {
                    alert('Hubo un error al agregar el producto al carrito');
                }
            }).fail(function() {
                alert('Error en la solicitud AJAX');
            });
        });
    });


    
    $(document).ready(function() {
        // Cuando se haga clic en "Pagar"
        $('#payButton').click(function() {
            // Mostrar mensaje de "procesando" antes de simular el pago
            Swal.fire({
                title: 'Procesando el pago...',
                text: 'Por favor, espere...',
                icon: 'info',
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Enviar solicitud AJAX para procesar el pago
            $.post('{{ route('cart.processPayment') }}', {
                _token: '{{ csrf_token() }}'
            }).done(function(response) {
                if(response.success) {
                    Swal.fire({
                        title: '¡Pago exitoso!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        window.location.href = '/';  // Redirigir al inicio
                    });
                } else {
                    Swal.fire({
                        title: 'Error en el pago',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'Volver a intentar'
                    });
                }
            }).fail(function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un error en la comunicación. Intenta nuevamente.',
                    icon: 'error',
                    confirmButtonText: 'Volver a intentar'
                });
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        Livewire.hook('message.processed', () => {
            window.scrollTo(0, 0);
        });
    });
</script>

@endsection
