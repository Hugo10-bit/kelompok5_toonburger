<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('store_settings')) {
            Schema::create('store_settings', function (Blueprint $table) {
                $table->id();
                $table->boolean('is_open')->default(true);
                $table->string('closed_reason', 120)->nullable();
                $table->string('operating_hours', 80)->default('17:00-22:00 WITA');
                $table->timestamp('closed_at')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->timestamps();
            });

            DB::table('store_settings')->insert([
                'is_open' => true,
                'closed_reason' => null,
                'operating_hours' => '17:00-22:00 WITA',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_settings');
    }
};
