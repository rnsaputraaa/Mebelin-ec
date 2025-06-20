
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('id_order');
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('customer_id');
            $table->decimal('total_harga', 15, 2);
            $table->enum('status_order', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->text('catatan')->nullable();
            $table->date('tanggal_order');
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id_customer')->on('customers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};