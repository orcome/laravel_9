<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMothersTable extends Migration
{
    public function up()
    {
        Schema::create('mothers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 60);
            $table->string('description')->nullable();
            $table->foreignId('creator_id')->constrained('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mothers');
    }
}
