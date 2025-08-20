<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('purchase_return_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->string('against_invoice_no');
            $table->date('invoice_date');
            $table->string('supplier_phone');
            $table->string('supplier_name');
            // $table->enum('customer_type', ['Retail', 'Whole Sale', 'Reselling']);
            $table->foreignId('payment_method_id')->constrained();
            $table->string('supplier_id');
            $table->decimal('sub_total', 10, 2);
            $table->decimal('gst_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
        });

        Schema::create('purchase_return_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->string('item_id');
            $table->string('barcode');
            $table->integer('quantity');
            $table->decimal('rate', 10, 2);
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        //
    }
};