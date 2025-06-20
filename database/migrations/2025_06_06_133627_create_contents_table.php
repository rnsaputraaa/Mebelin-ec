// 13. Migration untuk tabel content (comments)
// File: database/migrations/2024_01_01_000013_create_content_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('content', function (Blueprint $table) {
            $table->id('id_comment');
            $table->unsignedBigInteger('id_customer');
            $table->unsignedBigInteger('id_product');
            $table->text('comment');
            $table->timestamps();

            $table->foreign('id_customer')->references('id_customer')->on('customers')->onDelete('cascade');
            $table->foreign('id_product')->references('id_product')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('content');
    }
};