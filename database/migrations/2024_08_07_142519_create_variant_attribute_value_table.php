<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('variant_attribute_value', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Variant::class)->constrained();
            $table->foreignIdFor(\App\Models\AttributeValue::class)->constrained();

            $table->primary(['variant_id', 'attribute_value_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_attribute_value');
    }
};
