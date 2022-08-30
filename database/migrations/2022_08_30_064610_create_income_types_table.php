<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('income_types', function (Blueprint $table) {
            $table->id();

            $table->string('name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('income_types');
    }
};
