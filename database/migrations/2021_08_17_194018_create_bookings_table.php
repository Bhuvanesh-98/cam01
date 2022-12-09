<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('trx')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('service_id');
            $table->time('start_time');
            $table->decimal('amount');
            $table->integer('is_accepted')->default(0);
            $table->boolean('payment_confirmed')->default(false);
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
