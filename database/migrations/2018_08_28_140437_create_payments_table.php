<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amount_in_cents')->nullable(false);
            $table->string('currency', 3)->nullable(false);
            $table->string('country', 2)->nullable(false);
            $table->string('callback_url')->nullable(false);
            $table->string('chosen_method')->nullable(true);
            $table->json('request_data')->nullable(true);
            $table->json('response_data')->nullable(true);
            $table->dateTime('paid_at')->nullable(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
