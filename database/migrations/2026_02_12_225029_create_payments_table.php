<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {

            $table->id();

            // Relaciones
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('loan_id')->constrained()->cascadeOnDelete();

            // Información del pago
            $table->decimal('amount', 12,2);
            $table->string('concept'); // descripción del pago
            $table->string('receipt')->nullable(); // ruta de la imagen

            // Control administrativo
            $table->string('status')->default('sent'); 
            // sent | received | rejected

            $table->timestamp('confirmed_at')->nullable(); // fecha confirmación admin

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

