<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusSelesaiToShoppingListsTable extends Migration
{
    public function up()
    {
        Schema::table('shopping_lists', function (Blueprint $table) {
            $table->boolean('status_selesai')->default(false)->after('user_id');
        });
    }

    public function down()
    {
        Schema::table('shopping_lists', function (Blueprint $table) {
            $table->dropColumn('status_selesai');
        });
    }
}