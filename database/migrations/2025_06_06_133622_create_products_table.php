
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('id_product');
            $table->string('product_name', 100);
            $table->string('slug', 255)->unique();
            $table->text('description')->nullable();
            $table->integer('stok')->default(0);
            $table->integer('stok_sales')->default(0);
            $table->integer('size')->nullable();
            $table->integer('view')->default(0);
            $table->unsignedBigInteger('id_product_variant')->nullable();
            $table->unsignedBigInteger('id_category');
            $table->timestamps();

            $table->foreign('id_category')->references('id_category')->on('categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};