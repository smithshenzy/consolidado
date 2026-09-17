<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    /**
     * Listar movimientos
     */
    public function index()
    {
        $movements = Movement::orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($movements);
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('movements.create');
    }

    /**
     * Guardar movimiento
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
            'type' => ['required', 'in:income,expense'],
            'category' => ['required', 'string', 'max:255'],
            'concept' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0.01'],
        ]);

        Movement::create($validated);

        return redirect()
            ->route('movements.index')
            ->with('success', 'Movimiento registrado correctamente.');
    }

    /**
     * Mostrar un movimiento
     */
    public function show(Movement $movement)
    {
        return view('movements.show', compact('movement'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Movement $movement)
    {
        return view('movements.edit', compact('movement'));
    }

    /**
     * Actualizar movimiento
     */
    public function update(Request $request, Movement $movement)
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
            'type' => ['required', 'in:income,expense'],
            'category' => ['required', 'string', 'max:255'],
            'concept' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0.01'],
        ]);

        $movement->update($validated);

        return redirect()
            ->route('movements.index')
            ->with('success', 'Movimiento actualizado correctamente.');
    }

    /**
     * Eliminar movimiento
     */
    public function destroy(Movement $movement)
    {
        $movement->delete();

        return redirect()
            ->route('movements.index')
            ->with('success', 'Movimiento eliminado correctamente.');
    }
}
