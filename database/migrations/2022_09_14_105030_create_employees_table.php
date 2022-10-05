<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('full_name_en');
            $table->string('full_name_uk');
            $table->string('tax_number');
            $table->string('address_en');
            $table->string('address_uk');
            $table->string('bank_details_en');
            $table->string('bank_details_uk');
            $table->string('invoice_subject_en');
            $table->string('invoice_subject_uk');
            $table->string('invoice_description_en');
            $table->string('invoice_description_uk');
            $table->integer('last_invoice_number');
            $table->date('last_invoice_generated_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
