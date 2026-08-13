<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->string('check_in_method')->nullable(); // manual, face, fingerprint
            $table->string('check_out_method')->nullable();
            $table->decimal('total_hours', 8, 2)->nullable();
            $table->decimal('overtime_hours', 8, 2)->default(0);
            $table->enum('status', ['present', 'absent', 'late', 'early_exit', 'leave', 'holiday'])->default('present');
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            // Index for faster queries
            $table->index(['employee_id', 'date']);
            $table->unique(['employee_id', 'date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};