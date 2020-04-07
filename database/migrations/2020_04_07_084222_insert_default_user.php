<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Migrations\Migration;

class InsertDefaultUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Artisan::call( 'db:seed', [
                '--class' => 'UsersTableSeeder',
                '--force' => true ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
