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
            $table->string('publisher');
            $table->string('publish_date');
            $table->integer('republish_no');
            $table->string('license_no');
            $table->string('isbn_no');
            $table->string('avatar');
            $table->integer('views')->default(0);
            $table->integer('recommend')->default(0);
            $table->integer('hot')->default(0);
            $table->integer('sold')->default(0);
            $table->integer('qty');
            $table->integer('pages');
            $table->double('price');
            $table->string('lang');
            $table->string('desc');
            $table->string('detail',1600)->nullable();
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
