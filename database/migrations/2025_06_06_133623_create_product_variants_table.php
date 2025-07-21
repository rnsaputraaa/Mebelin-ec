<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id('id_product_variant')->autoIncrement();
            $table->string('color', 50)->nullable();
            $table->unsignedBigInteger('id_price');
            $table->timestamps();

            $table->foreign('id_price')->references('id_price')->on('prices')->onDelete('cascade');
        });

        // Add foreign key to products table after product_variants is created
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('id_product_variant')->references('id_product_variant')->on('product_variants')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['id_product_variant']);
        });
        
        Schema::dropIfExists('product_variants');
    }
};