<?php

namespace App\Livewire\HaztePadrino;

use App\Models\HaztePadrino;
use App\Models\Animals;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.user_type.auth')]  // Define el layout
class HaztePadrinoComponent extends Component
{
    use WithPagination;

    public $animalItems;  // Animal Items (usado para el formulario)
    public $isAdmin;      // Determina si el usuario es admin
    public $name, $surname, $address, $city, $dni, $phone, $email, $animal_id;
    public $animals;      // Puede ser usado en algún otro lugar (por ejemplo, en admin)

    protected $rules = [
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'dni' => 'required|string|max:15',
        'phone' => 'required|string|max:15',
        'email' => 'required|email',
        'animal_id' => 'required|exists:animals,id',
    ];

    // Almacenar un padrino
    public function store()
    {
        $this->validate();

        HaztePadrino::create([
            'name' => $this->name,
            'surname' => $this->surname,
            'address' => $this->address,
            'city' => $this->city,
            'dni' => $this->dni,
            'phone' => $this->phone,
            'email' => $this->email,
            'animal_id' => $this->animal_id,
            'user_id' => Auth::id(),  // Asignamos el id del usuario que está haciendo el apadrinamiento
            'date_apadrinamiento' => now(), // Fecha de apadrinamiento
        ]);

        session()->flash('success', '¡Gracias por apadrinar!');
        $this->reset();
    }

    // Inicializar el componente
    public function mount()
    {
        $user = Auth::user();
    
        // Obtener los animales asegurando que nunca sea null
        $this->animalItems = Animals::all() ?? collect(); 
        
        $this->isAdmin = $user && $user->type == 1;
    }
    

    // Renderiza la vista
    public function render()
    {
        // Obtener los padrinos con paginación
        $haztePadrino = HaztePadrino::with('animal')->paginate(6);
        
        // Ya tienes $this->animalItems, no es necesario sobrescribirla aquí.
        // Si necesitas animales para admin o algo más, usa directamente $this->animalItems
        $animalItems = $this->animalItems; // Usamos $this->animalItems aquí

        return view('livewire.hazte-padrino.hazte-padrino-component', [
            'haztePadrino' => $haztePadrino ?? collect(), // Usa una colección vacía si es null
            'isAdmin' => $this->isAdmin,
            'animalItems' => $animalItems, // Pasamos la variable correcta a la vista
        ]);
    }
}
