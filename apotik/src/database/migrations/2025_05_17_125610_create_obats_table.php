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
        Schema::create('obats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('jenis_id')->constrained('jenis')->onDelete('cascade');
            $table->foreignId('golongan_id')->constrained('golongans')->onDelete('cascade');
            $table->string('kode_obat');
            $table->string('nama_obat');
            $table->text('komposisi');
            $table->string('dosis');
            $table->string('aturan_pakai');
            $table->string('nomor_izin_edaar')->nullable();
            $table->date('tanggal_kadaluarsa')->nullable();
            $table->decimal('harga', 10, 2);
            $table->integer('stok');
            $table->string('status_label');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
