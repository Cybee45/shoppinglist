<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWaktuBelanjaToShoppingItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('shopping_items', function (Blueprint $table) {
            $table->timestamp('waktu_belanja')->nullable()->after('kategori');
            // setelah field 'kategori', dan nullable supaya aman
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('shopping_items', function (Blueprint $table) {
            $table->dropColumn('waktu_belanja');
        });
    }
}
