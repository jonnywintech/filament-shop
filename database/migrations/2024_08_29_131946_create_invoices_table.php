<?php

use App\Enums\Font;
use App\Enums\PrimaryColor;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->boolean('show_logo')->default(false);
            $table->string('logo')->nullable();
            $table->string('filename')->nullable();
            $table->string('color')->default(PrimaryColor::DEFAULT);
            $table->string('font')->default(Font::DEFAULT);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
