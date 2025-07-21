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
        // Check if column id_order already exists
        if (!Schema::hasColumn('order_items', 'id_order')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->bigInteger('id_order')->unsigned()->after('id_order_items');
                $table->foreign('id_order')->references('id_order')->on('orders')->onDelete('cascade');
                $table->index('id_order');
            });
        }

        // Update existing structure jika diperlukan
        Schema::table('order_items', function (Blueprint $table) {
            // Ensure all columns have correct data types
            $table->decimal('unit_price', 15, 2)->change();
            $table->decimal('subtotal', 15, 2)->change();
            $table->integer('total')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['id_order']);
            $table->dropColumn('id_order');
        });
    }
};