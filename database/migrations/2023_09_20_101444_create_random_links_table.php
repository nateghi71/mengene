<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRandomLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('random_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('linkable_id');
            $table->string('linkable_type');
            $table->string('token')->unique();
            $table->string('type');
            $table->string('suggest_id')->nullable();
            $table->string('guest_number');
            $table->unsignedInteger('number_try')->default(0);
            $table->timestamp('expires_at');
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
        Schema::dropIfExists('random_links');
    }
}
