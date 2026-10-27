<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('wallet_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('recipient_wallet_id')
                ->nullable()
                ->constrained('wallets')
                ->restrictOnDelete();

            $table->enum('type', [
                'deposit',
                'withdrawal',
                'transfer',
            ]);

            $table->decimal('amount', 15, 2);
            $table->decimal('fee', 15, 2)->default(0);

            $table->enum('status', [
                'pending',
                'completed',
                'failed',
            ])->default('pending');

            $table->string('reference')->unique();
            $table->text('description')->nullable();

            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            $table->index(['wallet_id', 'created_at']);
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};