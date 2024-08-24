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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->nullable();
            $table->string('username')->nullable();
            $table->decimal('balance', 20, 8)->default(0.00000000);
            $table->decimal('cashouts', 20, 8)->default(0.00000000);
            $table->integer('plan_id')->nullable();
            $table->integer('reference_user_id')->nullable();
            $table->float('affiliate_earns', 20, 8)->default(0.00000000);
            $table->float('affiliate_paid', 20, 8)->default(0.00000000);
            $table->string('ip_addr', 25)->nullable();
            $table->timestamps();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};
