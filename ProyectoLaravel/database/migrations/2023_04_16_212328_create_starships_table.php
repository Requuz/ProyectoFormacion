<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStarshipsTable extends Migration
{
    public function up()
    {
        Schema::create('starships', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('model');
            $table->string('manufacturer');
            $table->string('cost_in_credits')->nullable();
            $table->string('length')->nullable();
            $table->string('max_atmosphering_speed')->nullable();
            $table->string('crew')->nullable();
            $table->string('passengers')->nullable();
            $table->string('cargo_capacity')->nullable();
            $table->string('consumables')->nullable();
            $table->string('hyperdrive_rating')->nullable();
            $table->string('MGLT')->nullable();
            $table->string('starship_class')->nullable();
            $table->string('created')->nullable();
            $table->string('edited')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('starships');
    }
}

