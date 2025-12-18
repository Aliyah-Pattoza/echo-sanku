<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exchange_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('transaction_code')->unique();
            $table->decimal('total_points', 12, 2);
            $table->text('notes')->nullable();
            $table->timestamp('transaction_date');
            $table->timestamps();
            
            $table->index('transaction_code');
            $table->index('transaction_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exchange_transactions');
    }
};