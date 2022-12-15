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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name', 256);
            $table->date('reception')->index();
            $table->string('phone');
            $table->string('email');
            $table->decimal('salary', 8, 3);
            $table->string('image')->nullable();
            $table->bigInteger('manager_id')->unsigned();
            $table->bigInteger('position_id')->unsigned();
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->bigInteger('admin_created_id')->unsigned();
            $table->bigInteger('admin_updated_id')->unsigned();
            $table->foreign('admin_created_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_updated_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('employees');
    }
};
