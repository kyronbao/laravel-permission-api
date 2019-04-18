<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');

        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 64)->nullable();
            $table->string('name_cn', 64)->nullable();
            $table->string('path', 64)->nullable();
            $table->string('icon', 64)->nullable();
            $table->smallInteger('parent')->default(0);
            $table->timestamps();
        });

        Schema::create('role_has_menus', function (Blueprint $table) use ($tableNames) {
            $table->unsignedInteger('menu_id');
            $table->unsignedInteger('role_id');

            $table->primary(['menu_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
        Schema::dropIfExists('role_has_menus');
    }
}
