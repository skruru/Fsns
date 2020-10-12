<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('team_name', '50');
            $table->string('team_area', '20');
            $table->string('team_img')->nullable();
            $table->string('team_password', '50');
            $table->string('twitter', '100')->nullable();
            $table->string('instagram', '100')->nullable();
            $table->string('facebook', '100')->nullable();
            $table->string('mail', '100');
            $table->string('team_contents', '200');
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
        Schema::dropIfExists('teams');
    }
}
