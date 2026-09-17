<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Listar equipos
     */
    public function index()
    {
        $equipment = Equipment::orderBy('id', 'desc')->get();

        return response()->json($equipment);
    }


    /**
     * Registrar equipo
     */
    public function add(Request $request)
    {
        $validated = $request->validate([

            'registration_date' => 'nullable|date',
            'record_number' => 'nullable|string|max:255',
            'asset_code' => 'nullable|string|max:255',

            'dependency' => 'nullable|string|max:255',
            'area' => 'required|string|max:255',
            'encargado_area' => 'required|string|max:255',
            'encargado_equipo' => 'nullable|string|max:255',

            'type' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'operational_status' => 'nullable|string|max:255',

            'ram' => 'nullable|string|max:255',
            'ram_type' => 'nullable|string|max:255',

            'disk' => 'nullable|string|max:255',
            'disk_capacity' => 'nullable|string|max:255',

            'inventory_date' => 'nullable|date',
            'decommissioned' => 'nullable|boolean',
            'priority' => 'nullable|string|max:255',

            'procedure' => 'nullable|string',
            'action' => 'nullable|string',
            'descripcion' => 'nullable|string',

        ]);

        $equipment = Equipment::create($validated);

        return response()->json([
            'message' => 'Equipo registrado correctamente.',
            'equipment' => $equipment,
        ], 201);
    }


    /**
     * Mostrar equipo
     */
    public function show(Equipment $equipment)
    {
        return response()->json($equipment);
    }


    /**
     * Actualizar equipo
     */
    public function update(Request $request)
    {
        $validated = $request->validate([

            'id' => 'required|exists:equipment,id',

            'registration_date' => 'nullable|date',
            'record_number' => 'nullable|string|max:255',
            'asset_code' => 'nullable|string|max:255',

            'dependency' => 'nullable|string|max:255',
            'area' => 'required|string|max:255',
            'encargado_area' => 'required|string|max:255',
            'encargado_equipo' => 'nullable|string|max:255',

            'type' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'operational_status' => 'nullable|string|max:255',

            'ram' => 'nullable|string|max:255',
            'ram_type' => 'nullable|string|max:255',

            'disk' => 'nullable|string|max:255',
            'disk_capacity' => 'nullable|string|max:255',

            'inventory_date' => 'nullable|date',
            'decommissioned' => 'nullable|boolean',
            'priority' => 'nullable|string|max:255',

            'procedure' => 'nullable|string',
            'action' => 'nullable|string',
            'descripcion' => 'nullable|string',

            // Datos adicionales del hardware
            'sticker_inventario' => 'nullable|string',
            'hardware_detalle' => 'nullable|array',
            'hardware_general' => 'nullable|array',

        ]);

        $equipment = Equipment::findOrFail($validated['id']);

        $equipment->update($validated);

        return response()->json([
            'message' => 'Equipo actualizado correctamente.',
            'equipment' => $equipment->fresh(),
        ]);
    }


    /**
     * Eliminar equipo
     */
    public function delete($id)
    {
        $equipment = Equipment::findOrFail($id);

        $equipment->delete();

        return response()->json([
            'message' => 'Equipo eliminado correctamente.',
        ]);
    }
}
