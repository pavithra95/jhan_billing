<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('supplier_type')->nullable(); // Individual or Business
            $table->string('company_name')->nullable();
            $table->string('alt_phone')->nullable();
            $table->unsignedBigInteger('gst_state_id')->nullable();
            $table->string('gst_state_code')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn(['supplier_type', 'company_name', 'alt_phone', 'gst_state_id', 'gst_state_code']);
        });
    }
};
