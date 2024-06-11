<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('users_register', function (Blueprint $table) {            
            $table->id('user_id');
            $table->string('name', 225)->required();
            $table->string('email', 225)->required()->unique();
            $table->string('cpf',14)->required();
            $table->string('address', 225)->nullable();
            $table->string('password')->required();
            $table->string('cellphone', 14)->required()->unique();
            $table->string('cep', 14)->required();
            $table->date('date_birth')->required();
            $table->tinyInteger('status')->required();
            $table->timestamps();
            $table->softDeletes();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_register');    
    }
};
