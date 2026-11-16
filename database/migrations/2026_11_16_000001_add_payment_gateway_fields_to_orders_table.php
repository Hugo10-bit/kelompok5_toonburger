<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_gateway', 32)->nullable()->after('payment_method');
            $table->string('payment_reference', 100)->nullable()->index()->after('payment_gateway');
            $table->string('snap_token', 255)->nullable()->after('payment_reference');
            $table->text('snap_redirect_url')->nullable()->after('snap_token');
            $table->timestamp('paid_at')->nullable()->after('snap_redirect_url');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_gateway',
                'payment_reference',
                'snap_token',
                'snap_redirect_url',
                'paid_at',
            ]);
        });
    }
};
