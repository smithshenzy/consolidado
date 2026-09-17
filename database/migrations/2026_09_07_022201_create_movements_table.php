<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up(): void
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->id();

            $table->date('date');

            $table->enum('type', ['income', 'expense']);

            $table->string('category');

            $table->string('concept');

            $table->decimal('amount', 12, 2);

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('movements');
    }
};
