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
            $table->string('name');
            $table->enum('document' , ['six_dongs' , 'mangolehdar' , 'tak_bargeh', 'varasehee' , 'almosana', 'vekalati' , 'benchag' , 'sanad_rahni', 'gholnameh']);
            $table->enum('cooling' , ['water_cooler' , 'air_cooler', 'noting']);
            $table->enum('heating' , ['gas_heater' , 'fire_place' , 'underfloor_heating', 'split' , 'noting']);
            $table->enum('cabinets' , ['wooden' , 'metal' , 'melamine', 'mdf' , 'high_glass', 'noting']);
            $table->enum('floor_covering' , ['ceramic' , 'mosaic' , 'wooden', 'pvc']);
            $table->string('number');
            $table->boolean('discharge')->default(0);
            $table->boolean('exist_owner')->default(0);
            $table->integer('city_id');
            $table->integer('year_of_construction');
            $table->integer('year_of_reconstruction');
            $table->enum('status', ['active', 'unknown', 'deActive']);
            $table->enum('type_sale', ['rahn', 'buy']);
            $table->enum('type_work', ['home', 'office', 'shop', 'land']);
            $table->enum('type_build', ['house', 'apartment']);
            $table->enum('access_level', ['private', 'public']);
            $table->enum('type_file', ['business', 'buy', 'subscription' , 'people']);
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
            $table->foreignId('business_id')->nullable()->constrained('businesses')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->boolean('is_star')->default(false);
            $table->unsignedInteger('area');
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
        Schema::dropIfExists('landowners');
    }
}
