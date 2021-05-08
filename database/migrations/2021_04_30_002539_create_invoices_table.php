<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_number');
            $table->date('invoice_date');
            $table->date('dve_date');
            $table->unsignedBigInteger('product');
            $table->foreign('product')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedBigInteger('section');
            $table->foreign('section')->references('id')->on('sections')->onDelete('cascade');
            $table->string('discount');
            $table->string('rate_vat');
            $table->decimal('value_vat', 8, 2);
            $table->float('collected_money');
            $table->float('commission');
            $table->decimal('total', 8, 2);
            $table->string('status', 5);
            $table->string('note')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
}
