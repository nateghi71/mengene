<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('landowners', function (Blueprint $table) {
            $table->integer('number_of_unit_in_floor')->nullable(); //just apartment
            $table->integer('number_unit')->nullable(); //just apartment
            $table->integer('number_of_parking')->nullable(); //just apartment
            $table->integer('scale_of_parking')->nullable(); //just apartment
            $table->integer('number_of_wc')->nullable(); //just apartment
            $table->integer('postal_code')->nullable(); //just apartment
            $table->integer('number_of_store')->nullable(); //just apartment
            $table->integer('scale_of_store')->nullable(); //just apartment
            $table->integer('price_per_meter')->nullable();
            $table->integer('plaque')->nullable();
            $table->integer('number_of_dongs')->nullable();
            $table->enum('state_of_electricity' , ['null','nothing','shared','exclusive']);
            $table->enum('state_of_water' , ['null','nothing','shared','exclusive']);
            $table->enum('state_of_gas' , ['null','nothing','shared','exclusive']);
            $table->enum('state_of_phone' , ['null','nothing','working','not_working']);
            $table->enum('Direction_of_building' , ['null','north','south','east','west']);
            $table->enum('water_heater' , ['null','water_heater','powerhouse','package']);
            $table->enum('kitchen' , ['null','open','iranian']);
            $table->enum('wc' , ['null','iranian','frangi','iranian_and_frangi']);

            $table->boolean('terrace')->default(0);
            $table->boolean('air_conditioning_system')->default(0);
            $table->boolean('yard')->default(0);
            $table->boolean('furniture')->default(0);
            $table->boolean('Water_Well')->default(0);
            $table->boolean('green_space')->default(0);
            $table->boolean('pool')->default(0);
            $table->boolean('sauna')->default(0);
            $table->boolean('Jacuzzi')->default(0);
            $table->boolean('video_iphone')->default(0);
            $table->boolean('Underground')->default(0);
            $table->boolean('Wall_closet')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landowners', function (Blueprint $table) {
            $table->dropColumn('number_of_unit_in_floor');
            $table->dropColumn('number_unit');
            $table->dropColumn('number_of_parking');
            $table->dropColumn('scale_of_parking');
            $table->dropColumn('number_of_wc');
            $table->dropColumn('postal_code');
            $table->dropColumn('number_of_store');
            $table->dropColumn('scale_of_store');
            $table->dropColumn('price_per_meter');
            $table->dropColumn('plaque');
            $table->dropColumn('number_of_dongs');
            $table->dropColumn('state_of_electricity');
            $table->dropColumn('state_of_water');
            $table->dropColumn('state_of_gas');
            $table->dropColumn('state_of_phone');
            $table->dropColumn('Direction_of_building');
            $table->dropColumn('water_heater');
            $table->dropColumn('kitchen');
            $table->dropColumn('wc');

            $table->dropColumn('terrace');
            $table->dropColumn('air_conditioning_system');
            $table->dropColumn('yard');
            $table->dropColumn('furniture');
            $table->dropColumn('Water_Well');
            $table->dropColumn('green_space');
            $table->dropColumn('pool');
            $table->dropColumn('sauna');
            $table->dropColumn('Jacuzzi');
            $table->dropColumn('video_iphone');
            $table->dropColumn('Underground');
            $table->dropColumn('Wall_closet');
        });
    }
};
