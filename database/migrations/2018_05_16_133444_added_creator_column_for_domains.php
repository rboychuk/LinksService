<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedCreatorColumnForDomains extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->string('user_id')->after('domain');
        });

        Schema::table('links', function (Blueprint $table) {
            $table->string('meta')->after('link');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('links', function (Blueprint $table) {
            $table->dropColumn('meta');
        });

    }
}
