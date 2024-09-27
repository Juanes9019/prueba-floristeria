<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Insumo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Categoria_insumo;
use App\Exports\InsumoExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Excel;

class InsumoController extends Controller
{
    public function index(){
        $insumos = Insumo::all();
        $i = 0; 
        return view('Admin.insumo.index', compact('insumos', 'i'));
    }

    public function create()
    {
        $categoria_insumo= DB::table('categoria_insumos')->pluck('nombre', 'id');
        return view('Admin.insumo.create', compact('categoria_insumo'));
    }

    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $data = $request->validate([
            'id_categoria_insumo' => 'required',
            'nombre' => 'required',
            'cantidad_insumo' => 'required',
            'costo_unitario' => 'required',
            'perdida_insumo' => 'required',
        ]);

        $insumo = new Insumo;
        $insumo->id_categoria_insumo = $request->id_categoria_insumo;
        $insumo->nombre = $request->nombre;
        $insumo->cantidad_insumo = $request->cantidad_insumo;
        $insumo->costo_unitario = $request->costo_unitario;
        $insumo->perdida_insumo = $request->perdida_insumo;
        $insumo->costo_perdida = $request->costo_unitario * $request->perdida_insumo;

        if ($request->has('estado')) {
            $insumo->estado = 1;
       }


        $insumo->save();

        return redirect()->route('Admin.insumo')
            ->with('success', 'insumo creado con éxito.');
    
    }

    public function edit($id)    {
        $insumos = Insumo::find($id);
        $categoria_insumos = DB::table('categoria_insumos')->get();
        return view('Admin.insumo.edit', compact('insumos','categoria_insumos'));
    }

    public function update(Request $request, $id)
    {
        // Encuentra la categoria por su ID
        $insumos = Insumo::find($id);

        // Validaciones y lógica de actualización
        $request->validate([
            'id_categoria_insumo' => 'required',
            'nombre' => 'required',
            'cantidad_insumo' => 'required',
            'costo_unitario' => 'required',
            'perdida_insumo' => 'required',
        ]);

        //Calcula la nueva cantidad restando la pérdida
        $nueva_cantidad = $insumos->cantidad_insumo - $request->input('perdida_insumo');

        // Asignación de los campos del usuario desde el formulario
        $insumos->id_categoria_insumo = $request->input('id_categoria_insumo');
        $insumos->nombre = $request->input('nombre');
        $insumos->cantidad_insumo = $request -> $nueva_cantidad > 0 ? $nueva_cantidad : 0;
        $insumos->costo_unitario = $request->input('costo_unitario');
        $insumos->perdida_insumo = $request->input('perdida_insumo');
        $insumos->costo_perdida = $request->costo_unitario * $request->perdida_insumo;
        if ($request->has('estado')) {
            $insumos->estado = $request->estado;
        }
        

        $insumos->save();

        // Redirecciona a la vista de edición con un mensaje de éxito
        return redirect()->route('Admin.insumo', ['id' => $insumos->id])
        ->with('success', 'categoria actualizado exitosamente');
    }

    public function incrementarInsumo($id)
    {
        $insumo = Insumo::find($id);
        
        // Verifica si la cantidad de insumo es mayor a 0 antes de incrementar la pérdida
        if ($insumo->cantidad_insumo > 0) {
            // Incrementa la pérdida de insumo en 1
            $insumo->perdida_insumo += 1;
        
            // Reduce la cantidad de insumo en 1
            $insumo->cantidad_insumo = max(0, $insumo->cantidad_insumo - 1);
            $insumo->costo_perdida = $insumo->costo_unitario * $insumo->perdida_insumo;
            $insumo->save();
        
            return redirect()->route('Admin.insumo')->with('success', 'Insumo incrementado.');
        } else {
            return redirect()->route('Admin.insumo')->with('error', 'No se puede incrementar la pérdida, la cantidad de insumo es 0.');
        }
    }
    
    
    public function decrementarInsumo($id)
    {
        $insumo = Insumo::find($id);
        
        // Solo decrementa la pérdida y aumenta la cantidad si la pérdida es mayor que 0
        if ($insumo->perdida_insumo > 0) {
            // Decrementa la pérdida de insumo en 1
            $insumo->perdida_insumo -= 1;
    
            // Aumenta la cantidad de insumo en 1 solo si la cantidad era 0 antes de este incremento
            $insumo->cantidad_insumo += 1;
            $insumo->costo_perdida = $insumo->costo_unitario * $insumo->perdida_insumo;
            $insumo->save();
        
            return redirect()->route('Admin.insumo')->with('success', 'Insumo decrementado.');
        } else {
            return redirect()->route('Admin.insumo')->with('error', 'No se puede decrementar la pérdida, no hay pérdida registrada.');
        }
    }
    

    public function change_Status($id)
    {
        $insumo = Insumo::find($id);
        if ($insumo->estado == 1) {
            $insumo->estado = 0;
        } else {
            $insumo->estado = 1;
        }

        $insumo->save();
        return redirect()->back();
    }

    public function export($format)
    {
        $export = new InsumoExport;

        switch ($format) {
            case 'pdf':
                $pdf = Pdf::loadView('exports.insumos', [
                    'insumos' => Insumo::all()
                ])->setPaper('a4', 'portait') // Puedes cambiar a 'portrait' si prefieres
                    ->setOption('margin-left', '10mm')
                    ->setOption('margin-right', '10mm')
                    ->setOption('margin-top', '10mm')
                    ->setOption('margin-bottom', '10mm');
                return $pdf->download('insumos.pdf');
            case 'xlsx':
            default:
                return $export->download('insumos.xlsx', Excel::XLSX);
        }
    }

    public function destroy($id)
    {
        $insumo = Insumo::find($id);

        if ($insumo->estado == 1) {
            return redirect()->route('Admin.insumo')
                ->with('error', 'No se puede eliminar un insumo Activa');
        }
        try {
            $insumo->delete();
            return redirect()->route('Admin.insumo')
                ->with('success','Insumo eliminado con éxito');
        } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() == 23000) {
                    return redirect()->route('Admin.insumo')
                        ->with('error', 'No se puede eliminar el insumo porque está asociado a una compra.');
                }
                return redirect()->route('Admin.insumo')
                    ->with('error', 'Error al intentar eliminar el insumo.');
        }     
    }
}