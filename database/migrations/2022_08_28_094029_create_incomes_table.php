<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->bigInteger('value')->unsigned();

            $table->timestamp('completed_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('incomes');
    }
};
