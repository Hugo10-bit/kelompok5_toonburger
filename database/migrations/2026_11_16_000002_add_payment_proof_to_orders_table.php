<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->longText('payment_proof')->nullable()->after('paid_at');
            $table->timestamp('payment_proof_uploaded_at')->nullable()->after('payment_proof');
            $table->string('payment_proof_note', 255)->nullable()->after('payment_proof_uploaded_at');
            $table->string('payment_proof_rejected_reason', 255)->nullable()->after('payment_proof_note');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_proof',
                'payment_proof_uploaded_at',
                'payment_proof_note',
                'payment_proof_rejected_reason',
            ]);
        });
    }
};
