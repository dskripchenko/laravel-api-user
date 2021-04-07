<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class User2userRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user2user_roles', function (Blueprint $table) {
            $table->bigInteger('user_id')->index();
            $table->bigInteger('user_role_id')->index();
            $table->timestamp('created_at')->nullable();
        });

        Schema::table('user2user_roles', function (Blueprint $table) {
            $table->primary(['user_id', 'user_role_id']);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('user_role_id')
                ->references('id')
                ->on('user_roles')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user2user_roles');
    }
}
