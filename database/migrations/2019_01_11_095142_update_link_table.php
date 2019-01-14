<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLinkTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('links', function (Blueprint $table) {
            $table->string('target_url');
            $table->string('anchor');
            $table->boolean('enabled');
            $table->boolean('dublicate_domain');
            $table->boolean('theme');
            $table->boolean('theme_domain');
            $table->boolean('link_in_search');
            $table->string('position');
            $table->integer('price');
            $table->string('resource');
            $table->longText('comment');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
