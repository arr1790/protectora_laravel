<?php

namespace App\Livewire\Donation;

use App\Models\Donation;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.user_type.auth')]  
class DonationComponent extends Component
{
    use WithPagination;

    public $isAdmin;  
    public $name;
    public $amount;

  
    public function store()
    {
        $this->validate([
            'name'   => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
        ]);
        
        Donation::create([
            'name'          => $this->name,
            'amount'        => $this->amount,
            'user_id'       => Auth::id(),  
            'date_donation' => now(), 
        ]);
        
        $this->reset(['name', 'amount']);
        session()->flash('success', '¡Gracias por tu donación!');
    }

   
    public function mount()
    {
        $user = Auth::user();
       $this->isAdmin = $user && $user->type == 1;
    }

    // Renderiza la vista
    public function render()
    {
       
        $donation = $this->isAdmin 
                    ? Donation::with('user')->paginate(6) 
                    : collect([]);

        return view('livewire.donation.donation-component', [
            'donation' => $donation,
            'isAdmin'  => $this->isAdmin,
        ]);
    }
}
