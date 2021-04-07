<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UserRole2userPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_role2user_permissions', function (Blueprint $table) {
            $table->bigInteger('user_role_id')->index();
            $table->bigInteger('user_permission_id')->index();
        });

        Schema::table('user_role2user_permissions', function (Blueprint $table) {
            $table->primary(['user_role_id', 'user_permission_id']);
            $table->foreign('user_role_id')
                ->references('id')
                ->on('user_roles')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('user_permission_id')
                ->references('id')
                ->on('user_permissions')
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
        Schema::dropIfExists('user_role2user_permissions');
    }
}
