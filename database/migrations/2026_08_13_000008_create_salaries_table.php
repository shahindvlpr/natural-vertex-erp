<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('salary_structure_id')->nullable()->constrained('salary_structures')->onDelete('set null');
            
            $table->string('salary_month');
            $table->year('salary_year');
            
            // Earnings
            $table->decimal('basic_salary', 15, 2)->default(0);
            $table->decimal('house_rent', 15, 2)->default(0);
            $table->decimal('medical_allowance', 15, 2)->default(0);
            $table->decimal('conveyance', 15, 2)->default(0);
            $table->decimal('other_allowance', 15, 2)->default(0);
            $table->decimal('bonus', 15, 2)->default(0);
            $table->decimal('overtime_amount', 15, 2)->default(0);
            
            // Deductions
            $table->decimal('tax_deduction', 15, 2)->default(0);
            $table->decimal('loan_deduction', 15, 2)->default(0);
            $table->decimal('advance_deduction', 15, 2)->default(0);
            $table->decimal('other_deduction', 15, 2)->default(0);
            
            // Attendance
            $table->integer('total_present')->default(0);
            $table->integer('total_absent')->default(0);
            $table->integer('total_late')->default(0);
            $table->integer('total_leave')->default(0);
            $table->decimal('total_overtime_hours', 8, 2)->default(0);
            
            $table->decimal('gross_salary', 15, 2)->default(0);
            $table->decimal('net_salary', 15, 2)->default(0);
            
            $table->enum('status', ['draft', 'generated', 'approved', 'paid'])->default('draft');
            $table->date('payment_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('notes')->nullable();
            
            $table->foreignId('generated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['employee_id', 'salary_month', 'salary_year']);
            $table->unique(['employee_id', 'salary_month', 'salary_year']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('salaries');
    }
};