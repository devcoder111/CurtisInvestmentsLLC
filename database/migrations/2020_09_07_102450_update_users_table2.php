<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'first_name');
            $table->string('last_name');
            $table->string('country_code', 10);
            $table->unsignedBigInteger('referrer_id')->nullable();

            $table->foreign('referrer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('first_name', 'name');
                $table->dropColumn('last_name');
                $table->dropColumn('country_code');
                $table->dropForeign(['referrer_id']);
                $table->dropColumn('referrer_id');
            });
        });
    }
}
