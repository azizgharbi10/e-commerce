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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            
            // Relation avec commande
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            
            // Référence produit (nullable si produit supprimé du catalogue)
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            
            // Snapshots produit (conservation historique)
            $table->string('product_name');
            $table->string('product_slug');
            $table->decimal('product_price', 10, 2);
            
            // Quantité commandée
            $table->integer('quantity');
            
            // Sous-total (price × quantity, calculé)
            $table->decimal('subtotal', 10, 2);
            
            $table->timestamps();
            
            // Index pour requêtes fréquentes
            $table->index('order_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
