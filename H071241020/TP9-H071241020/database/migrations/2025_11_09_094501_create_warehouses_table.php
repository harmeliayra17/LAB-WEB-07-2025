<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->notNullable();
            $table->text('location')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('warehouses');
    }
};
