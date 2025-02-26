@extends('layouts.user_type.auth')

@section('content')

{{-- 
Inicio de la protectora --}}
<div class="row mt-4 justify-content-center">
  <div class="col-lg-10 col-md-12 mb-4"> 
    <div class="card h-100"> 
      <div class="card-body p-5 text-center">
        <img src="{{ asset('assets/img/protectoraaa.jpg') }}" alt="Logo" 
             class="img-fluid mb-4" 
             style="max-width: 100%; height: auto; max-height: 400px;" /> 
        <h2 class="mb-3">Adopta</h2>
        <p class="fs-5">Selecciona y reserva tu nueva mascota de forma sencilla. ¡Sigue los pasos!</p>
      </div>
    </div>
  </div>
</div>

<!-- Sección de historia de la protectora -->
<div class="row mt-4 justify-content-center">
  <div class="col-lg-10 col-md-12">
    <div class="card h-100">
      <div class="card-body p-5">
        <h2 class="text-center mb-4">Nuestra Historia</h2>
        <p class="fs-5">
          Nuestra protectora nació en <strong>2021</strong> con el propósito de rescatar, cuidar y buscar un hogar amoroso 
          para animales en situación de abandono. Desde entonces, hemos logrado dar en adopción a más de <strong>300</strong> 
          animales y seguimos trabajando cada día para mejorar sus vidas.
        </p>
        <p class="fs-5">
          Creemos en la adopción responsable y en el compromiso con nuestros peludos amigos. ¡Gracias por formar parte de esta misión!
        </p>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4 d-flex flex-wrap justify-content-center">
  <!-- Contacto -->
  <div class="col-xl-3 col-md-4 col-sm-6 mb-3">
    <div class="card h-100">
      <div class="card-body d-flex align-items-center justify-content-center">
        <i class="fas fa-phone-alt me-3 fs-5"></i>
        <p class="text-sm mb-0 text-center text-capitalize font-weight-bold">
          CONTACTO<br>
          <span class="text-primary">957 447 568</span>
        </p>
      </div>
    </div>
  </div>

  <!-- Dirección -->
  <div class="col-xl-3 col-md-4 col-sm-6 mb-3">
    <div class="card h-100">
      <div class="card-body d-flex align-items-center justify-content-center">
        <i class="fas fa-map-marker-alt me-3 fs-5"></i>
        <p class="text-sm mb-0 text-center text-capitalize font-weight-bold">
          DIRECCIÓN<br>
          <span class="text-primary">Calle la Almona, 8</span>
        </p>
      </div>
    </div>
  </div>

  <!-- Email -->
  <div class="col-xl-3 col-md-4 col-sm-6 mb-3">
    <div class="card h-100">
      <div class="card-body d-flex align-items-center justify-content-center">
        <i class="fas fa-envelope me-3 fs-5"></i>
        <p class="text-sm mb-0 text-center text-capitalize font-weight-bold">
          EMAIL<br>
          <span class="text-primary">info@protectora.com</span>
        </p>
      </div>
    </div>
  </div>

  <!-- Horario -->
  <div class="col-xl-3 col-md-4 col-sm-6 mb-3">
    <div class="card h-100">
      <div class="card-body d-flex align-items-center justify-content-center">
        <i class="fas fa-clock me-3 fs-5"></i>
        <p class="text-sm mb-0 text-center text-capitalize font-weight-bold">
          HORARIO<br>
          <span class="text-primary">Lun-Vie 9:00-18:00</span>
        </p>
      </div>
    </div>
  </div>
</div>

@endsection
@push('dashboard')
  <script>
    window.onload = function() {
      var ctx = document.getElementById("chart-bars").getContext("2d");

      new Chart(ctx, {
        type: "bar",
        data: {
          labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
            label: "Sales",
            tension: 0.4,
            borderWidth: 0,
            borderRadius: 4,
            borderSkipped: false,
            backgroundColor: "#fff",
            data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
            maxBarThickness: 6
          }, ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
              },
              ticks: {
                suggestedMin: 0,
                suggestedMax: 500,
                beginAtZero: true,
                padding: 15,
                font: {
                  size: 14,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
                color: "#fff"
              },
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false
              },
              ticks: {
                display: false
              },
            },
          },
        },
      });


      var ctx2 = document.getElementById("chart-line").getContext("2d");

      var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

      gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
      gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

      var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

      gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
      gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

      new Chart(ctx2, {
        type: "line",
        data: {
          labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
              label: "Mobile apps",
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 0,
              borderColor: "#cb0c9f",
              borderWidth: 3,
              backgroundColor: gradientStroke1,
              fill: true,
              data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
              maxBarThickness: 6

            },
            {
              label: "Websites",
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 0,
              borderColor: "#3A416F",
              borderWidth: 3,
              backgroundColor: gradientStroke2,
              fill: true,
              data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
              maxBarThickness: 6
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                padding: 10,
                color: '#b2b9bf',
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                color: '#b2b9bf',
                padding: 20,
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
          },
        },
      });
    }
  </script>
@endpush

