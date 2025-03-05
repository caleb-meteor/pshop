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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('')->comment('类型');
            $table->string('title')->default('')->comment('标题');
            $table->text('description')->nullable()->comment('描述');
            $table->integer('setting')->default(0)->comment('设置');
            $table->boolean('is_effect')->default(0)->comment('是否生效');
            $table->dateTime('end_time')->nullable()->comment('结束时间');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
