<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShoppingListIdToShoppingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shopping_items', function (Blueprint $table) {
            $table->foreignId('shopping_list_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shopping_items', function (Blueprint $table) {
            $table->dropForeign(['shopping_list_id']);
            $table->dropColumn('shopping_list_id');
        });
    }
};