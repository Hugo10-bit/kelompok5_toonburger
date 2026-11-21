<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE users ALTER COLUMN avatar TYPE text');
            DB::statement('ALTER TABLE products ALTER COLUMN image TYPE text');
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->longText('avatar')->nullable()->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->longText('image')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE users ALTER COLUMN avatar TYPE varchar(100)');
            DB::statement('ALTER TABLE products ALTER COLUMN image TYPE varchar(255)');
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar', 100)->nullable()->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('image', 255)->nullable()->change();
        });
    }
};
