<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('modelos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marca_id');
            $table->string('nome', 30);
            $table->string('imagem', 100);
            $table->integer('numero_portas');
            $table->integer('lugares');
            $table->boolean('air_bag');
            $table->boolean('abs');
            $table->timestamps();

            //foreign key (constraints)
            $table->foreign('marca_id')->references('id')->on('marcas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modelos', function (Blueprint $table) {
            $table->dropForeign('modelos_marca_id_foreign');
            $table->dropColumn('marca_id');
        });

        Schema::dropIfExists('modelos');
    }
};
