<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->char('code', 2)->unique();
            $table->string('name', 128)->unique();
            $table->boolean('default')->default(false);
        });

        if (DB::getDefaultConnection() === 'pgsql') {
            DB::statement('create unique index on languages ("default") where "default" = true');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
