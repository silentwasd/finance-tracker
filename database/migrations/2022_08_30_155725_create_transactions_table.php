<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->string('type');

            $table->bigInteger('category_id');

            $table->bigInteger('value')->unsigned();

            $table->timestamp('completed_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
