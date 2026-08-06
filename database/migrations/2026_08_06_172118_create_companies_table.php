<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('website')->nullable();
            
            // Logo & Signature
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('signature')->nullable();
            
            // Tax Information
            $table->string('vat_number')->nullable();
            $table->string('bin_number')->nullable();
            $table->string('tin_number')->nullable();
            $table->string('tax_zone')->nullable();
            
            // Financial Settings
            $table->string('currency')->default('BDT');
            $table->string('currency_symbol')->default('৳');
            $table->string('timezone')->default('Asia/Dhaka');
            $table->string('fiscal_year')->nullable();
            $table->date('fiscal_year_start')->nullable();
            $table->date('fiscal_year_end')->nullable();
            
            // Invoice Settings
            $table->string('invoice_prefix')->default('INV-');
            $table->integer('invoice_start_number')->default(1000);
            $table->string('invoice_footer')->nullable();
            
            // System Settings
            $table->boolean('is_active')->default(true);
            $table->boolean('maintenance_mode')->default(false);
            $table->text('maintenance_message')->nullable();
            
            // Social Links
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }
};