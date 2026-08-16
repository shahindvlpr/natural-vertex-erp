<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('goods_receives', function (Blueprint $table) {
            $table->id();
            $table->string('receive_number')->unique();
            $table->foreignId('purchase_order_id')->constrained()->onDelete('cascade');
            $table->date('receive_date');
            $table->text('received_by')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'partial', 'complete'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('goods_receives');
    }
};