<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')->references('id')->on('authors');
            $table->string('publish_date');
            $table->integer('republish_no');
            $table->string('license_no');
            $table->string('isbn_no');
            $table->string('avatar');
            $table->integer('views')->default(0);
            $table->integer('recommend')->default(0);
            $table->integer('sold')->default(0);
            $table->integer('qty');
            $table->string('lang');
            $table->string('detail')->nullable();
            $table->integer('pages')->nullable();
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
        Schema::dropIfExists('books');
    }
}
