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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('')->comment('名称');
            $table->decimal('price')->default(0)->comment('价格');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('product_views', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('product_id')->comment('商品id');
            $table->date('date')->nullable()->comment('日期')->index('date');
            $table->string('ip')->nullable()->comment('ip');
            $table->unsignedBigInteger('num')->default(0)->comment('浏览量');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_views');
    }
};
