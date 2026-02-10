<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
       Schema::create('flashcard_views', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id');
    $table->unsignedBigInteger('card_id');
    $table->timestamp('viewed_at')->useCurrent();
    $table->timestamps();
});
    }

    public function down()
    {
        Schema::dropIfExists('flashcard_views');
    }
};
