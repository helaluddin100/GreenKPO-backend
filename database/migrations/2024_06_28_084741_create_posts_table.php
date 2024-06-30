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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title', 255);
            $table->string('small_title', 255)->nullable();
            $table->string('image', 255);
            $table->text('description');
            $table->json('tag_id')->nullable();
            $table->string('slug', 255)->unique();
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_descriptions', 255)->nullable();
            $table->string('meta_keyword', 255)->nullable();

            $table->unsignedInteger('view_count')->default(0)->nullable();
            $table->boolean('status')->default(true);

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
        Schema::dropIfExists('posts');
    }
};
