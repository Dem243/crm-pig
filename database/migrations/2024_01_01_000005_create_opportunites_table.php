<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opportunites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('commercial_id')->constrained('users')->cascadeOnDelete();
            $table->string('titre');
            $table->decimal('montant', 12, 2)->default(0);
            $table->enum('etape', [
                'prospection', 'qualification', 'proposition', 'negociation', 'gagne', 'perdu',
            ])->default('prospection');
            $table->unsignedTinyInteger('probabilite')->default(0);
            $table->date('date_cloture_prevue')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opportunites');
    }
};
