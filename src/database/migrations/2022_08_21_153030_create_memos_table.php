<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('books')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('group_id')->constrained('groups')->onUpdate('cascade')->onDelete('cascade');
            $table->string('before_reading_content', 255);
            $table->string('reading_content', 255)->nullable();
            $table->string('after_reading_content', 255)->nullable();
            $table->string('actionlist1_content', 255)->nullable();
            $table->string('actionlist2_content', 255)->nullable();
            $table->string('actionlist3_content', 255)->nullable();
            $table->string('feedback1_content', 255)->nullable();
            $table->string('feedback2_content', 255)->nullable();
            $table->string('feedback3_content', 255)->nullable();
            $table->boolean('is_viewed')->default(0);
            $table->timestamps();
        });
    }

    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memos');
    }
}
