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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id', 64)->default('')->comment('用户id')->index('user_id');
            $table->string('order_number')->default('')->comment('订单号');
            $table->decimal('total_amount')->default(0)->comment('总金额');
            $table->string('status')->default('')->comment('状态');
            $table->dateTime('payment_time')->nullable()->comment('支付时间');
            $table->string('delivery_status')->default('')->comment('发货状态');
            $table->string('delivery_remark')->default('')->comment('发货备注');
            $table->dateTime('delivery_time')->nullable()->comment('发货时间');
            $table->string('remark')->default('')->comment('订单备注');
            $table->text('voucher')->nullable()->comment('支付凭证');
            $table->decimal('reduction')->default(0)->comment('满减金额');
            $table->json('discount')->nullable()->comment('优惠信息');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('order_products', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('order_id')->default(0)->comment('订单id')->index('idx_order_id');
            $table->unsignedBigInteger('product_id')->default(0)->comment('商品id');
            $table->decimal('price')->default(0)->comment('价格');
            $table->decimal('discount_price')->default(0)->comment('优惠');
            $table->unsignedInteger('quantity')->default(0)->comment('数量');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('order_addresses', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('order_id')->default(0)->comment('订单id')->index('idx_order_id');
            $table->string('name')->default('')->comment('收货人');
            $table->string('phone')->default('')->comment('手机号');
            $table->string('address')->default('')->comment('地址');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('order_banks', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('order_id')->default(0)->comment('订单id')->index('idx_order_id');
            $table->unsignedBigInteger('bank_id')->default(0)->comment('银行id');
            $table->string('name', 30)->default('')->comment('银行卡持有人');
            $table->string('card_number', 30)->default('')->comment('银行卡号');
            $table->string('bank_name', 30)->default('')->comment('银行名称');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_products');
        Schema::dropIfExists('order_addresses');
        Schema::dropIfExists('order_banks');
    }
};
