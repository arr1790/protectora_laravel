<?php

namespace App\Livewire\Volunteer;

use Livewire\Component;
use App\Models\Volunteer;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.user_type.auth')]  
class VolunteerComponent extends Component
{
    use WithPagination;

    public $isAdmin;
    public $name, $surname, $phone, $date_volunteers, $task, $weekly_hours;

    protected $rules = [
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'date_volunteers' => 'required|date',
        'task' => 'required|in:redes sociales,limpieza,mantenimiento',
        'weekly_hours' => 'required|in:5,10,15,20',
    ];

 
    public function store()
    {
        $this->validate();

        Volunteer::create([
            'name' => $this->name,
            'surname' => $this->surname,
            'phone' => $this->phone,
            'date_volunteers' => $this->date_volunteers,
            'task' => $this->task,
            'weekly_hours' => $this->weekly_hours,
            'user_id' => Auth::id(),
        ]);

        session()->flash('success', '¡Gracias por unirte como voluntario!');
        $this->reset(); 
    }

   
    public function mount()
    {
        $user = Auth::user();
        $this->isAdmin = $user && $user->type == 1;
    }

    
    public function render()
    {
        // Si el usuario es admin, obtiene todos los voluntarios con paginación
        // Si no es admin, se pasa una colección vacía
        $volunteers = $this->isAdmin 
            ? Volunteer::with('user')->paginate(6) 
            : collect([]);

        return view('livewire.volunteer.volunteer-component', [
            'volunteers' => $volunteers,
            'isAdmin'    => $this->isAdmin,
        ]);
    }
}
