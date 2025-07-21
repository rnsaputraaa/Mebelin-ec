
// 11. Migration untuk tabel wishlist
// File: database/migrations/2024_01_01_000011_create_wishlist_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wishlist', function (Blueprint $table) {
            $table->id('id_wishlist');
            $table->unsignedBigInteger('id_customer');
            $table->unsignedBigInteger('id_product');
            $table->timestamps();

            $table->foreign('id_customer')->references('id_customer')->on('customers')->onDelete('cascade');
            $table->foreign('id_product')->references('id_product')->on('products')->onDelete('cascade');
            
            // Prevent duplicate entries
            $table->unique(['id_customer', 'id_product']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('wishlist');
    }
};