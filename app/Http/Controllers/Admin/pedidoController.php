<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::all();
        $i = 0; 
        return view('Admin.pedido.index', compact('pedidos', 'i'));
    }

    public function cambiar_estado(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        if ($pedido->estado === 'nuevo') {
            $pedido->estado = 'preparacion';
        } elseif ($pedido->estado === 'preparacion') {
            $pedido->estado = 'en camino';
        } elseif ($pedido->estado === 'en camino') {
            $pedido->estado = 'entregado';
        }

        $pedido->save();

        return redirect()->back()->with('success', 'Estado del pedido actualizado correctamente.');
    }

    public function mostrar($id)
    {
        $pedido = Pedido::with('detalles.producto')->findOrFail($id);
        $i = 0; 
        return view('Admin.pedido.mostrar', compact('pedido','i'));
    }

    //funcionalidad en flutter


    public function getPedidos()
    {
        $pedidos = Pedido::all();
        return response()->json($pedidos);
    }

    public function aceptarPedido()
    {
        $pedido = Pedido::findOrFail($id);

        if ($pedido->estado === 'nuevo') {
            $pedido->estado = 'preparacion';
        } elseif ($pedido->estado === 'preparacion') {
            $pedido->estado = 'en camino';
        } elseif ($pedido->estado === 'en camino') {
            $pedido->estado = 'entregado';
        }

        $pedido->save();

        return response()->json(['message' => 'Estado del pedido actualizado correctamente', 'pedido' => $pedido], 200);
    }

    public function rechazarPedido()
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();

        return response()->json(['message' => 'Pedido rechazado y eliminado correctamente'], 200);
    }
}
