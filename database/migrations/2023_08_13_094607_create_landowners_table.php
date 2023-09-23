<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateLandownersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landowners', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_star')->default(false);
            $table->enum('status', ['active', 'unknow', 'deactive']);
            $table->enum('type_sale', ['rahn', 'buy']);
            $table->enum('type_work', ['home', 'office']);
            $table->enum('type_sale', ['house', 'apartment']);
            $table->string('name');
            $table->string('number');
            $table->string('city');
            $table->integer('meterage')->nullable();
            $table->integer('rooms')->nullable();
            $table->date('expiry_date');
            $table->text('description');
            $table->integer('rahnd')->nullable();
            $table->integer('ejare')->nullable();
            $table->integer('price')->nullable();
            $table->boolean('elevator')->nullable();
            $table->boolean('parking')->nullable();
            $table->boolean('store')->nullable();
            $table->integer('floor')->nullable();
            $table->integer('num_floor')->nullable();
            $table->foreignId('business_id')->constrained('businesses');
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
        Schema::dropIfExists('landowners');
    }
}
