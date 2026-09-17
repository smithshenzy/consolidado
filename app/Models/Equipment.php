<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipment';
    protected $fillable = [
        'registration_date',
        'record_number',
        'asset_code',

        'dependency',
        'area',
        'encargado_area',
        'encargado_equipo',

        'type',
        'brand',
        'operational_status',

        'ram',
        'ram_type',
        'disk',
        'disk_capacity',

        'inventory_date',
        'decommissioned',
        'priority',

        'procedure',
        'action',
        'descripcion',

        'sticker_inventario',
        'hardware_detalle',
        'hardware_general',
    ];

    protected $casts = [
        'registration_date' => 'datetime',
        'inventory_date' => 'date',
        'decommissioned' => 'boolean',

        'hardware_detalle' => 'array',
        'hardware_general' => 'array',
    ];
}
