<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {

            $table->engine = 'MyISAM';

            $table->bigIncrements('id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->string('avatar')->default('https://via.placeholder.com/100');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('address')->default('');
            $table->string('city')->default('');
            $table->string('zip')->default('');
            $table->string('country')->default('');
            $table->string('email')->default('');
            $table->string('phone')->default('');
            $table->text('note')->nullable();
            $table->bigInteger('group_id')->unsigned()->nullable();
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
