<?php

namespace App\Livewire\Animals;

use App\Models\Animals;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\Layout;


#[Layout('layouts.user_type.auth')]
class AnimalsComponent extends Component
{
    use WithPagination;


    public $search = "";
    public $totalRegistros = 0;
    public $cant = 6;
    public $isAdmin = false;


    public $animalItem;
    public $name, $race, $age, $sex, $size, $description, $status, $image, $newImage;
    public $Id = 0;
    public $preparation, $experience, $time, $adoption_reason, $animalId; 

    public $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'image' => 'required|url',
    ];

    public function render()
    {
        $animalItems = Animals::where('name', 'like', '%' . $this->search . '%')
            ->paginate($this->cant);
    
        return view('livewire.animals.animals-component', [
            'animals' => $animalItems,
           
        ]);
    }
    
    
    public function mount()
    {

        $this->isAdmin = auth()->user() && auth()->user()->type == 1;
        $this->search = '';
        $this->totalRegistros = Animals::count();
        $this->resetPage();
    }
 

    

    public function create()
    {
        $this->Id = 0;
        $this->reset(['name', 'race', 'age', 'sex', 'size', 'description', 'status', 'image', 'newImage']);
        $this->resetErrorBag();
        $this->dispatch('openModal', 'animalModal');
    }

    public function store()
    {

        $this->validate([
            'sex' => 'required|in:Masculino,Femenino',
            'size' => 'required|in:Pequeño,Grande',
            'description' => 'required|min:5',
            'status' => 'required',
            'image' => 'nullable|url',
        ]);

        $animal = Animals::find($this->Id);
        if ($animal) {

            if ($this->image && filter_var($this->image, FILTER_VALIDATE_URL)) {
                $animal->image = $this->image;
            }

            $animal->name = $this->name;
            $animal->race = $this->race;
            $animal->age = $this->age;
            $animal->sex = $this->sex;
            $animal->size = $this->size;
            $animal->description = $this->description;
            $animal->status = $this->status;

            $animal->save();
            session()->flash('success', '¡Animal actualizado exitosamente!');
            $this->resetInputs();
            $this->dispatch('closeModal', 'animalModal');
            $this->dispatch('msg', 'Animal actualizado exitosamente');
            return;
        } else {

            $animal = new Animals();
            $animal->name = $this->name;
            $animal->race = $this->race;
            $animal->age = $this->age;
            $animal->sex = $this->sex;
            $animal->size = $this->size;
            $animal->description = $this->description;
            $animal->status = $this->status;
            $animal->image = $this->image;

            $animal->save();
            session()->flash('success', '¡Animal creado exitosamente!');
            $this->resetInputs();
            $this->dispatch('closeModal', 'animalModal');
            $this->dispatch('msg', 'Animal creado exitosamente');
            return;
        }
    }



    public function edit(Animals $animal)
    {
        $this->Id = $animal->id;
        $this->name = $animal->name;
        $this->race = $animal->race;
        $this->age = $animal->age;
        $this->sex = $animal->sex;
        $this->size = $animal->size;
        $this->description = $animal->description;
        $this->status = $animal->status;
        $this->image = $animal->image;


        $this->dispatch('openModal', 'animalModal');
    }


    public function update()
    {

        $this->validate([
            'image' => 'nullable|url',
        ]);


        $animal = Animals::find($this->Id);
        if ($animal) {

            if ($this->image && filter_var($this->image, FILTER_VALIDATE_URL)) {
                $animal->image = $this->image;
            }


            $animal->update([
                'name' => $this->name,
                'race' => $this->race,
                'age' => $this->age,
                'sex' => $this->sex,
                'size' => $this->size,
                'description' => $this->description,
                'status' => $this->status,
                'image' => $animal->image,
            ]);

            session()->flash('success', '¡Animal actualizado exitosamente!');
            $this->resetInputs();
            $this->dispatch('closeModal', 'animalModal');
            $this->dispatch('msg', 'Animal actualizado exitosamente');
        }
    }


    public function delete($id)
    {
        $animal = Animals::findOrFail($id);
        $animal->delete();

        $this->totalRegistros = Animals::count();
        session()->flash('success', '¡Animal eliminado exitosamente!');
    }


    public function resetInputs()
    {
        $this->name = '';
        $this->race = '';
        $this->age = '';
        $this->sex = '';
        $this->size = '';
        $this->description = '';
        $this->status = '';
        $this->image = '';
        $this->newImage = '';
        $this->Id = null;
    }
    //
    public function viewAnimalDetails($id)
    {
        $animal = Animals::find($id);

        if ($animal) {

            $this->Id = $animal->id;
            $this->name = $animal->name;
            $this->race = $animal->race;
            $this->age = $animal->age;
            $this->sex = $animal->sex;
            $this->size = $animal->size;
            $this->description = $animal->description;
            $this->status = $animal->status;
            $this->image = $animal->image;


            $this->dispatch('openModal', 'animalDetailsModal');
        }
    }
    public function openAdoptionModal($animalId)
    {
        $this->animalId = $animalId; // Guarda el ID del animal
        $this->reset(['preparation', 'experience', 'time', 'adoption_reason']); // Restablece los campos del formulario
        $this->dispatch('openModal', 'adoptionModal'); // Muestra el modal
    }

    // Maneja el envío de la solicitud de adopción
    public function submitAdoptionRequest()
    {
        // Validación
        $this->validate([
            'preparation' => 'required|string|max:500',
            'experience' => 'required|string|max:500',
            'time' => 'required|numeric|min:1',
            'adoption_reason' => 'required|string|max:500',
        ]);

        // Aquí no guardamos la solicitud en la base de datos,
        // pero puedes enviar los datos por email, almacenarlos en una sesión, etc.
        // Por ejemplo, si quieres mostrar un mensaje de éxito:
        session()->flash('message', '¡Solicitud de adopción enviada con éxito!');
        
        // Restablecer los campos del formulario
        $this->reset(['preparation', 'experience', 'time', 'adoption_reason']);
        
        // Cerrar el modal
        $this->dispatch('closeModal');
    }
}


