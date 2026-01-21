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
        Schema::create('home_components', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('component')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['is_active', 'component']);
        });

        Schema::create('home_components_order', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('layout_id');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->foreign('layout_id')->references('id')->on('home_components')->onDelete('cascade');
            $table->index(['layout_id', 'sort_order']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_components_order');
        Schema::dropIfExists('home_components');
    }
};
