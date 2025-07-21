// 8. Migration untuk tabel product_images
// File: database/migrations/2024_01_01_000008_create_product_images_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id('id_product_images');
            $table->unsignedBigInteger('product_id');
            $table->string('url_gambar');
            $table->boolean('first_picture')->default(false);
            $table->integer('sort')->default(0);
            $table->timestamps();

            $table->foreign('product_id')->references('id_product')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_images');
    }
};