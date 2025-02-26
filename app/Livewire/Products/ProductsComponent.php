<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.user_type.auth')]
class ProductsComponent extends Component
{
    use WithPagination;

    public $name, $description, $price, $image, $Id = 0;
    public $totalRegistros = 0;
    public $isAdmin = false;
    public $cant = 5;
    public $search = '';

    // Reglas de validación
    public $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'image' => 'required|url',
    ];

    public function render()
    {
        // Usamos $this->cant para definir el número de productos por página
        $products = Product::where('name', 'like', '%' . $this->search . '%')
            ->paginate($this->cant);

        return view('livewire.products.products-component', [
            'products' => $products,
        ]);
    }
    public function mount()
    {
        $this->isAdmin = auth()->user() && auth()->user()->type == 1;
        $this->totalRegistros = Product::count();
        $this->search = '';
    }

    public function create()
    {
        $this->reset(['name', 'description', 'price', 'image', 'Id']);
        $this->resetErrorBag();
        $this->dispatch('openModal', 'modalProducts');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->image = $product->image;
        $this->Id = $product->id;
        
        $this->dispatch('openModal', 'modalProducts');
    }

    public function store()
    {
        
        $this->validate();
    
        
        Product::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $this->image,
            'user_id' => auth()->id(),  
        ]);
    
      
        $this->resetInputs();
    
      
        $this->dispatch('closeModal', 'modalProducts');
    
        session()->flash('message', 'Producto creado con éxito.');
    }
    
    public function update()
    {
     
        $this->validate();
    
        
        $product = Product::findOrFail($this->Id);
        $product->update([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $this->image,
           
        ]);
    
        
        $this->resetInputs();
    
       
        $this->dispatch('closeModal', 'modalProducts');
    
     
        session()->flash('message', 'Producto actualizado con éxito.');
    }
    

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        $this->totalRegistros = Product::count();
        session()->flash('message', 'Producto eliminado con éxito.');
    }

    public function resetInputs()
    {
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->image = '';
        $this->Id = 0;
    }


}