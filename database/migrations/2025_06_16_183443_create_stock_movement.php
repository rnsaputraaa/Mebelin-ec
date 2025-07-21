<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('report_stock', function (Blueprint $table) {
            $table->id('id_report_stock');
            $table->unsignedBigInteger('id_product');
            $table->enum('type', ['in', 'out']); // in = masuk, out = keluar
            $table->integer('quantity'); // jumlah stok (bisa + atau -)
            $table->date('movement_date'); // tanggal pergerakan stok
            $table->string('reference_type')->nullable(); // 'purchase', 'sale', 'adjustment', 'return', etc
            $table->string('reference_id')->nullable(); // ID dari order/purchase/dll
            $table->text('notes')->nullable(); // catatan tambahan
            $table->string('created_by')->nullable(); // user yang input
            $table->timestamps();

            // Foreign key
            $table->foreign('id_product')->references('id_product')->on('products')->onDelete('cascade');
            
            // Index untuk performa
            $table->index(['id_product', 'movement_date']);
            $table->index(['type', 'movement_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('report_stock');
    }
};