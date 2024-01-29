<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->onDelete('cascade');
            $table->foreignId('business_id')->constrained('businesses')->onDelete('cascade');
            $table->unsignedInteger('amount');
            $table->unsignedInteger('tax_amount')->default(0);
            $table->unsignedInteger('coupon_amount')->default(0);
            $table->unsignedInteger('paying_amount');
            $table->enum('payment_type' , ['pos' , 'cash' , 'shabaNumber' , 'cardToCard' , 'online']);
            $table->enum('order_type' , ['buy_file' , 'buy_package' , 'buy_credit']);
            $table->tinyInteger('payment_status')->default(0);
            $table->tinyInteger('use_wallet')->default(0);
            $table->string('ref_id')->nullable();
            $table->string('token' , 100)->nullable();
            $table->enum('gateway_name' , ['zarinpal']);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
