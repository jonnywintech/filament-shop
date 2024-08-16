<?php

use App\Enums\Font;
use App\Enums\PrimaryColor;
use App\Enums\RecordsPerPage;
use App\Enums\TableSortDirection;
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
        Schema::create('appearances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('primary_color')->default(PrimaryColor::DEFAULT);
            $table->string('font')->default(Font::DEFAULT);
            $table->string('table_sort_direction')->default(TableSortDirection::DEFAULT);
            $table->unsignedTinyInteger('records_per_page')->default(RecordsPerPage::DEFAULT);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appearances');
    }
};
