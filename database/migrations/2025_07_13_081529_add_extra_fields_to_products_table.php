<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('subcategory_id')->nullable()->after('category_id');
            $table->string('brand')->nullable()->after('hsn_code');

            $table->unsignedBigInteger('sale_unit')->nullable()->after('unit_id');
            $table->unsignedBigInteger('purchase_unit')->nullable()->after('sale_unit');
            $table->decimal('conversion_value', 10, 2)->default(1)->after('purchase_unit');

            $table->enum('has_mg', ['Yes', 'No'])->default('No')->after('conversion_value');
            $table->decimal('mg_value', 10, 2)->nullable()->after('has_mg');
            $table->string('mg_to_unit')->nullable()->after('mg_value');

            $table->decimal('mrp', 10, 2)->nullable()->after('price');
            $table->decimal('sale_price', 10, 2)->nullable()->after('mrp');
            $table->decimal('retail_price', 10, 2)->nullable()->after('sale_price');
            $table->decimal('wholesale_price', 10, 2)->nullable()->after('retail_price');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'subcategory_id', 'brand',
                'sale_unit', 'purchase_unit', 'conversion_value',
                'has_mg', 'mg_value', 'mg_to_unit',
                'mrp', 'sale_price', 'retail_price', 'wholesale_price'
            ]);
        });
    }
};
