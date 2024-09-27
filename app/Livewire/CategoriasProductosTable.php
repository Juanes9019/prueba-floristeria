<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Categoria_Producto;

class CategoriasProductosTable extends Component
{
    use WithPagination;

    public $porPagina = 10;
    public $buscar = "";
    public $ordenarColumna = 'id_categoria_producto';
    public $ordenarForma = 'asc';
    public $primeraCarga = true;

    protected $queryString = [
        'buscar' => ['except' => ''],
        'ordenarColumna' => ['except' => 'id_categoria_producto'],
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
        $proveedor = Categoria_Producto::find($id);
        $proveedor->estado = !$proveedor->estado;
        $proveedor->save();
    }

    public function render()
    {
        return view('livewire.categorias-productos-table', [
            'categorias_productos' => Categoria_Producto::search($this->buscar)
                ->orderBy($this->ordenarColumna, $this->ordenarForma)
                ->paginate($this->porPagina)
        ]);
    }
}