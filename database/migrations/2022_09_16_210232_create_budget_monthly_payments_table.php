<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('budget_monthly_payments', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->bigInteger('category_id')->unsigned()->nullable();

            $table->bigInteger('value')->unsigned();

            $table->bigInteger('created_transaction_id')->unsigned()->nullable();

            $table->timestamp('will_created_at');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_transaction_id')
                ->references('id')
                ->on('transactions')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('budget_monthly_payments');
    }
};
