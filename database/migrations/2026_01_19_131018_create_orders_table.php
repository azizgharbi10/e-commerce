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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            // Numéro de commande unique
            $table->string('order_number', 50)->unique();
            
            // Client (nullable pour guest checkout)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            // Informations client (obligatoires même pour guests)
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();
            
            // Adresse de livraison (JSON pour flexibilité)
            $table->json('shipping_address');
            $table->json('billing_address')->nullable();
            
            // Montants (snapshot au moment de la commande)
            $table->decimal('total_amount', 10, 2);
            
            // Statut de la commande
            $table->enum('status', [
                'pending',
                'confirmed',
                'processing',
                'shipped',
                'delivered',
                'cancelled',
                'refunded'
            ])->default('pending');
            
            // Paiement (pour future implémentation)
            $table->string('payment_method')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            
            // Notes client
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            // Index pour recherches fréquentes
            $table->index('order_number');
            $table->index('customer_email');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
