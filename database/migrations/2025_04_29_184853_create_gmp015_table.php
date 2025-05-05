<?php

use App\Enums\Flag;
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
        Schema::create('gmp015', function (Blueprint $table) {

            $table->bigIncrements('GMP015_Id');
            $table->text('GMP015_Canal');
            $table->enum('GMP015_Flag_Ativo', Flag::toArray())->default('S');
            $table->text('GMP015_Correlacao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gmp015');
    }
};
