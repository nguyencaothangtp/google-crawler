<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeywordStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keyword_statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('keyword');
            $table->unsignedTinyInteger('adwords_num');
            $table->unsignedBigInteger('search_results_num');
            $table->unsignedSmallInteger('links_num');
            $table->text('html_content');
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
        Schema::dropIfExists('keyword_statistics');
    }
}
