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
        Schema::create('pengirimen', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('pesanan_id')->constrained('pesanans');
            $table->foreignId('pengirim_id')->constrained('pengirims');
            $table->string('alamat');
            $table->decimal('jarak', 8, 2);
            $table->decimal('total', 10, 2);
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
        Schema::dropIfExists('pengirimen');
    }
};
