<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->string('about_me')->nullable();
            $table->string('type')->nullable();
            $table->rememberToken();
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
        {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign(['user_id']); // Eliminar la clave foránea
                $table->dropColumn('user_id'); // Eliminar la columna user_id
            });
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign(['product_id']); // Eliminar la clave foránea
                $table->dropColumn('product_id'); // Eliminar la columna product_id
            });
            Schema::dropIfExists('users');
        }
    }
            
}
