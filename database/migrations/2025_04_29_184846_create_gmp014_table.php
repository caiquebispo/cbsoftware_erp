<?php

use App\Enum\Flag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gmp014', function (Blueprint $table) {

            $table->bigIncrements('GMP014_Id');
            $table->foreignId('GMP014_GMP015_Id')
                ->constrained('gmp015','GMP015_Id')
                ->onDelete('cascade');
            $table->float('GMP014_Comissao')->default(0);
            $table->float('GMP014_Custo_Sac')->default(0);
            $table->enum('GMP014_Comissao_Sobre_Frete', Flag::toArray())->default('N');
            $table->enum('GMP014_Multiplicar_Pela_Quantidade', Flag::toArray())->default('N');
            $table->enum('GMP014_Flag_Ativo', Flag::toArray())->default('S');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gmp014');
    }
};
