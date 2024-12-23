<?php

namespace App\Livewire\Producto;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Producto;

class indexProducto extends Component
{
    use WithPagination;

    public $porPagina = 10;
    public $buscar = "";
    public $ordenarColumna = 'id';
    public $ordenarForma = 'asc';
    public $primeraCarga = true;

    protected $queryString = [
        'buscar' => ['except' => ''],
        'ordenarColumna' => ['except' => 'id'],
        'ordenarForma' => ['except' => 'asc'],
        'page' => ['except' => 1]
    ];

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function sortBy($columna)
    {
        if ($this->ordenarColumna == $columna) {
            $this->ordenarForma = $this->ordenarForma === 'asc' ? 'desc' : 'asc';
        } else {
            $this->ordenarColumna = $columna;
            $this->ordenarForma = 'asc';
        }

        $this->resetPage();
        $this->primeraCarga = false;
    }

    public function changeStatus($id)
    {
        $producto = Producto::find($id);
        $producto->estado = !$producto->estado;
        $producto->save();
    }

    public function loadProducto($id)
    {
        // Emitir el evento sin usar emitTo, ya que el componente está en la misma vista
        $this->emit('loadProducto', $id);
    }




    public function render()
    {
        return view('livewire.producto.index-producto', [
            'productos' => Producto::search($this->buscar)
                ->orderBy($this->ordenarColumna, $this->ordenarForma)
                ->paginate($this->porPagina)
        ]);
    }
}
