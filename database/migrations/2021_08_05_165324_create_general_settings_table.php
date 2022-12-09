<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('sitename',50);
            $table->string('site_currency',10);
            $table->string('currency_icon',5);
            $table->boolean('user_reg')->default(1);
            $table->boolean('blog_comment')->default(1);
            $table->string('logo',50)->nullable();
            $table->string('icon',50)->nullable();
            $table->string('color',50);
            $table->string('email_from',100);
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
        Schema::dropIfExists('general_settings');
    }
}
