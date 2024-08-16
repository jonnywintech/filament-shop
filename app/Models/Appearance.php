<?php

namespace App\Models;

use App\Enums\Font;
use App\Enums\PrimaryColor;
use App\Enums\RecordsPerPage;
use App\Enums\TableSortDirection;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\AppearanceFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Appearance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'primary_color',
        'font',
        'table_sort_direction',
        'records_per_page',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'primary_color' => PrimaryColor::class,
        'font' => Font::class,
        'table_sort_direction' => TableSortDirection::class,
        'records_per_page' => RecordsPerPage::class,
    ];

    protected static function newFactory(): Factory
    {
        return AppearanceFactory::new();
    }


    public function primaryColor(): ?string
    {
        return $this->color;
    }

    public function font(): ?string
    {
        return $this->font;
    }

    public function tableSortDirection(): ?string
    {
        return $this->table_sort_direction;
    }

    public function recordsPerPage(): ?string
    {
        return $this->records_per_page;
    }
}
