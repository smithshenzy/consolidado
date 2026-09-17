<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {

            $table->id();

            // Información del registro
            $table->dateTime('registration_date')->nullable();
            $table->string('record_number')->nullable();
            $table->string('asset_code')->nullable();

            // Ubicación y responsables
            $table->string('dependency')->nullable();
            $table->string('area')->nullable();
            $table->string('encargado_area')->nullable();
            $table->string('encargado_equipo')->nullable();

            // Características del equipo
            $table->string('type')->nullable();
            $table->string('brand')->nullable();
            $table->string('operational_status')->nullable();

            // Hardware
            $table->string('ram')->nullable();
            $table->string('ram_type')->nullable();
            $table->string('disk')->nullable();
            $table->string('disk_capacity')->nullable();

            // Inventario
            $table->date('inventory_date')->nullable();
            $table->boolean('decommissioned')->default(false);
            $table->string('priority')->nullable();

            // Gestión técnica
            $table->text('procedure')->nullable();
            $table->text('action')->nullable();
            $table->text('descripcion')->nullable();

            // Detalles de inventario y hardware
            $table->text('sticker_inventario')->nullable();
            $table->json('hardware_detalle')->nullable();
            $table->json('hardware_general')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
