<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sto_workers', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->enum('payment_type', ['percent', 'fixed'])->default('fixed');
            $table->decimal('rate', 12, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('sto_clients', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        Schema::create('sto_orders', function (Blueprint $table): void {
            $table->id();
            $table->string('number')->unique();
            $table->foreignId('client_id')->constrained('sto_clients')->cascadeOnDelete();
            $table->string('service');
            $table->decimal('amount', 12, 2)->default(0);
            $table->enum('status', ['new', 'in_progress', 'ready', 'completed', 'cancelled'])->default('new');
            $table->timestamps();
        });

        Schema::create('sto_order_workers', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('order_id')->constrained('sto_orders')->cascadeOnDelete();
            $table->foreignId('worker_id')->constrained('sto_workers')->cascadeOnDelete();
            $table->decimal('amount', 12, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('sto_expenses', function (Blueprint $table): void {
            $table->id();
            $table->text('description');
            $table->decimal('amount', 12, 2);
            $table->string('category');
            $table->date('expense_date');
            $table->timestamps();
        });

        Schema::create('sto_worker_payments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('worker_id')->constrained('sto_workers')->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained('sto_orders')->nullOnDelete();
            $table->decimal('amount', 12, 2);
            $table->date('paid_at')->nullable();
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->timestamps();
        });

        Schema::create('sto_parts', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('article')->nullable();
            $table->unsignedInteger('quantity')->default(0);
            $table->decimal('price', 12, 2)->default(0);
            $table->unsignedInteger('min_quantity')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sto_worker_payments');
        Schema::dropIfExists('sto_order_workers');
        Schema::dropIfExists('sto_expenses');
        Schema::dropIfExists('sto_orders');
        Schema::dropIfExists('sto_parts');
        Schema::dropIfExists('sto_clients');
        Schema::dropIfExists('sto_workers');
    }
};
