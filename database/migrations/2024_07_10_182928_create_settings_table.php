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
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        $table->text('home_video')->nullable();
        $table->string('right_image')->nullable();
        $table->string('left_image')->nullable();
        $table->string('banner_title_a')->default("Democratising Carbon Accounting");
        $table->string('banner_title_b')->default("One Business At A Time");
        $table->text('banner_description')->nullable();
        $table->timestamps();
    });

    // Insert a default setting record
    DB::table('settings')->insert([
        'home_video' => null,
        'right_image' => null,
        'left_image' => null,
        'banner_title_a' => 'Democratising Carbon Accounting',
        'banner_title_b' => 'One Business At A Time',
        'banner_description' => 'Carbon Accounting is easy, it\'s meant for businesses of all sizes and with GreenKPO it takes only a few steps to understand how to assess, manage and take action about your business\'s Carbon emission.',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};