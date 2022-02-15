<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordedMappingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recorded_mapping_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('inspection_detail_id');
            $table->unsignedInteger('mapping_item_id');
            $table->unsignedInteger('x_point');
            $table->unsignedInteger('y_point');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recorded_mapping_items');
    }
}
