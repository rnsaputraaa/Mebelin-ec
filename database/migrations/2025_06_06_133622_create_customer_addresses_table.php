
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id('id_customer_addresses');
            $table->string('alamat_lengkap', 120);
            $table->string('kota', 40);
            $table->string('provinsi', 20);
            $table->string('kode_pos', 20);
            $table->boolean('alamat_utama')->default(false);
            $table->string('patokan', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_addresses');
    }
};
