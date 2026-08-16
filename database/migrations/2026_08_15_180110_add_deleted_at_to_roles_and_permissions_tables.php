<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Roles Table
        if (Schema::hasTable('roles') && !Schema::hasColumn('roles', 'deleted_at')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        // Permissions Table
        if (Schema::hasTable('permissions') && !Schema::hasColumn('permissions', 'deleted_at')) {
            Schema::table('permissions', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        // User Roles Table
        if (Schema::hasTable('user_roles') && !Schema::hasColumn('user_roles', 'deleted_at')) {
            Schema::table('user_roles', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        // Role Permissions Table
        if (Schema::hasTable('role_permissions') && !Schema::hasColumn('role_permissions', 'deleted_at')) {
            Schema::table('role_permissions', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('user_roles', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('role_permissions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};