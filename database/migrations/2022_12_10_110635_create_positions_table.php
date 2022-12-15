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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 256)->unique()->index();
            $table->bigInteger('admin_created_id')->unsigned();
            $table->bigInteger('admin_updated_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('admin_created_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_updated_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('positions');
    }
};
