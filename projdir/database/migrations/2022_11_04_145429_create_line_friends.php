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
        Schema::create('line_friends', function (Blueprint $table) {
            $table->id()->comment('IDシーケンス');
            $table->string('line_id')->comment('LINEシステムID');
            $table->string('line_name')->nullable()->comment('LINEユーザー名');
            $table->string('line_icon_url', 1024)->nullable()->comment('LINEアバターアイコンURL');
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
        Schema::dropIfExists('line_friends');
    }
};
