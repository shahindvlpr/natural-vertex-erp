<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('barcode')->nullable();
            $table->string('sku')->nullable();
            
            // Foreign Key সরিয়ে দিন - শুধু column রাখুন
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            
            $table->tinyInteger('product_type')->default(1)->comment('1: Raw Material, 2: Finished Good');
            $table->decimal('purchase_price', 15, 2)->default(0);
            $table->decimal('selling_price', 15, 2)->default(0);
            $table->decimal('wholesale_price', 15, 2)->default(0);
            $table->integer('min_stock')->default(0);
            $table->integer('max_stock')->default(0);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_manufactured')->default(false);
            $table->boolean('has_expiry')->default(false);
            $table->integer('warranty_period')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Index যোগ করুন (Foreign Key ছাড়া)
            $table->index('category_id');
            $table->index('brand_id');
            $table->index('unit_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};