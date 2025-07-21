<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('customer_addresses', function (Blueprint $table) {
            // Tambah kolom id_customer setelah id_customer_addresses
            $table->unsignedBigInteger('id_customer')->after('id_customer_addresses');
            
            // Tambah foreign key constraint
            $table->foreign('id_customer')
                  ->references('id_customer')
                  ->on('customers')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('customer_addresses', function (Blueprint $table) {
            $table->dropForeign(['id_customer']);
            $table->dropColumn('id_customer');
        });
    }
};