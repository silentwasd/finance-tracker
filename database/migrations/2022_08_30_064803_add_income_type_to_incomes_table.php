<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->bigInteger('income_type')
                ->unsigned()
                ->nullable()
                ->after('name');
        });
    }

    public function down()
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn('income_type');
        });
    }
};
