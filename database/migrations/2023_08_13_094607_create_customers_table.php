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
            $table->id(); //code file #1
            $table->enum('type_file', ['business','public', 'buy', 'subscription' , 'people']);
            $table->boolean('is_star')->default(false);
            $table->enum('type_sale', ['rahn', 'buy']);
            $table->enum('access_level', ['private', 'public']);
            $table->enum('status', ['active', 'unknown', 'deActive']);
            $table->string('name');
            $table->string('number');
            $table->integer('scale');
            $table->integer('city_id');
            $table->unsignedInteger('area');
            $table->date('expire_date');
            $table->unsignedBigInteger('rahn_amount')->nullable(); //just rahn
            $table->unsignedBigInteger('rent_amount')->nullable();//just rahn
            $table->unsignedBigInteger('selling_price')->nullable();//just buy
            $table->enum('type_work', ['home', 'office', 'commercial', 'training', 'industrial', 'other']);
            $table->enum('type_build', ['house', 'apartment', 'shop','land','workshop','parking','store' , 'hall' ,]);
            $table->enum('document' , ['all' ,'six_dongs' , 'mangolehdar' , 'tak_bargeh', 'varasehee' , 'almosana', 'vekalati' , 'benchag' , 'sanad_rahni', 'gholnameh']); //just buy
            $table->text('address');
            $table->boolean('discharge')->default(0);
            $table->boolean('exist_owner')->default(0);
            //more
            $table->integer('year_of_construction')->nullable();
            $table->integer('year_of_reconstruction')->nullable();
            $table->integer('number_of_rooms')->nullable();
            $table->boolean('elevator')->nullable();
            $table->boolean('parking')->nullable();
            $table->boolean('store')->nullable();
            $table->integer('floor')->nullable(); //just apartment
            $table->integer('floor_number')->nullable(); //just apartment
            $table->enum('floor_covering' , ['null' , 'ceramic' , 'mosaic' , 'wooden', 'pvc','others']);
            $table->enum('cooling' , ['null' , 'water_cooler' , 'air_cooler','nothing']);
            $table->enum('heating' , ['null' , 'heater' , 'fire_place' , 'underfloor_heating', 'split','nothing']);
            $table->enum('cabinets' , ['null' , 'wooden' , 'memberan', 'metal' , 'melamine', 'mdf', 'mdf_and_metal' , 'high_glass','noting']);
            $table->enum('view', ['null' , 'brick', 'rock', 'Cement','composite','Glass','ceramic','hybrid' , 'others']);
            $table->text('description')->nullable();
            $table->foreignId('business_id')->nullable()->constrained('businesses')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
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
