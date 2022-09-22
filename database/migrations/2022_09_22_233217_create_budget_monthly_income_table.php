<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('budget_monthly_income', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('value')->unsigned();

            $table->timestamp('expected_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('budget_monthly_income');
    }
};
