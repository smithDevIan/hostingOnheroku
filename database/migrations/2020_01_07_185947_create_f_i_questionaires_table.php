<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFIQuestionairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('f_i_questionaires', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_of_data_collector');
            $table->string('facility_name');
            $table->string('facility_code');
            $table->string('facility_type');
            $table->string('facility_org');
            $table->string('state_name');
            $table->string('state_code');
            $table->string('lga_name');
            $table->string('lga_code');
            $table->string('facility_respondent');
            $table->string('household_respondent');
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
        Schema::dropIfExists('f_i_questionaires');
    }
}
