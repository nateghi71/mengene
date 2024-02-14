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
            $table->integer('postal_code')->nullable(); //just apartment
            $table->integer('plaque')->nullable();
            $table->enum('state_of_electricity' , ['null','nothing','shared','exclusive']);
            $table->enum('state_of_water' , ['null','nothing','shared','exclusive']);
            $table->enum('state_of_gas' , ['null','nothing','shared','exclusive']);
            $table->enum('state_of_phone' , ['null','nothing','working','not_working']);
            $table->enum('Direction_of_building' , ['null','north','south','east','west']);
            $table->enum('water_heater' , ['null','water_heater','powerhouse','package']);

            $table->boolean('terrace')->default(0);
            $table->boolean('air_conditioning_system')->default(0);
            $table->boolean('yard')->default(0);
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
            $table->dropColumn('postal_code');
            $table->dropColumn('plaque');
            $table->dropColumn('state_of_electricity');
            $table->dropColumn('state_of_water');
            $table->dropColumn('state_of_gas');
            $table->dropColumn('state_of_phone');
            $table->dropColumn('Direction_of_building');
            $table->dropColumn('water_heater');

            $table->dropColumn('terrace');
            $table->dropColumn('air_conditioning_system');
            $table->dropColumn('yard');
            $table->dropColumn('pool');
            $table->dropColumn('sauna');
            $table->dropColumn('Jacuzzi');
            $table->dropColumn('video_iphone');
            $table->dropColumn('Underground');
            $table->dropColumn('Wall_closet');
        });
    }
};
