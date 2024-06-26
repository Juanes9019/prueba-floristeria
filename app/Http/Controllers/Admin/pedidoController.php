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

    public function pedidos_usuario($user_id)
    {
        $pedidos = Pedido::where('user_id', $user_id)->get();
        return response()->json($pedidos, 200);
    }

    //controlador para ver pedido en flutter
    public function getPedidos()
    {
        $pedidos = Pedido::all();
        return response()->json($pedidos);
    }

    //controlador para aceptar pedido e flutter
    public function aceptarPedido($id)
    {
        //id para encontrar el pedido
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
 
    //controlador para rechazar pedido en flutter
    //prueba
    public function rechazarPedido($id)
    {
        try {
            $pedido = Pedido::findOrFail($id);
            $pedido->delete();
            return response()->json(['message' => 'Pedido rechazado y eliminado correctamente'], 200);
        } catch (Exception $e) {
            // Log del error para depuración
            Log::error('Error al rechazar pedido: ' . $e->getMessage());
            return response()->json(['error' => 'Error al rechazar pedido'], 500);
        }
    }
    

    //controlador para ver el detalle en fluuter
    public function detalle_flutter($id)
    {
        //pedido para flutter
        $pedido = Pedido::with('detalles.producto')->findOrFail($id);
        return response()->json($pedido);
    }
}

