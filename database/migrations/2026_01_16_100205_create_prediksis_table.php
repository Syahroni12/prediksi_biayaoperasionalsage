<?php

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
        Schema::create('prediksi', function (Blueprint $table) {
            $table->id();
            $table->float('luas_lahan');
            $table->float('mean_hujan');
            $table->float('mean_suhu');

            $table->unsignedBigInteger('varietas_id');
            $table->foreign('varietas_id')->references('id')->on('varietas')->onDelete('cascade');

            $table->float('estimasi_panen');
            $table->bigInteger('estimasi_biaya');
            $table->integer('estimasi_waktu_panen');
            $table->date('tanggal_panen');
            $table->date('tanggal_tanam');
            $table->bigInteger("harga_beli");



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prediksis');
    }
};
