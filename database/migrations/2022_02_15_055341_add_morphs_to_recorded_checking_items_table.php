<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMorphsToRecordedCheckingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recorded_checking_items', function (Blueprint $table) {
            //
            $table->after('inspection_detail_id', function($table){
                $table->morphs('itemable');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recorded_checking_items', function (Blueprint $table) {
            //
            $table->dropMorphs('itemable');
        });
    }
}
