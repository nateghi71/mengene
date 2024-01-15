<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number');
            $table->integer('city_id');
            $table->enum('status', ['active', 'unknown', 'deActive']);
            $table->enum('type_sale', ['rahn', 'buy']);
            $table->enum('type_work', ['home', 'office']);
            $table->enum('type_build', ['house', 'apartment']);
            $table->enum('access_level', ['private', 'public']);
            $table->integer('scale')->nullable();
            $table->integer('number_of_rooms')->nullable();
            $table->text('description');
            $table->unsignedBigInteger('rahn_amount')->nullable();
            $table->unsignedBigInteger('rent_amount')->nullable();
            $table->unsignedBigInteger('selling_price')->nullable();
            $table->boolean('elevator')->nullable();
            $table->boolean('parking')->nullable();
            $table->boolean('store')->nullable();
            $table->integer('floor')->nullable();
            $table->integer('floor_number')->nullable();
            $table->foreignId('business_id')->constrained('businesses')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_star')->default(false);
            $table->date('expire_date');
            $table->softDeletes();
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
        Schema::dropIfExists('customers');
    }
}
