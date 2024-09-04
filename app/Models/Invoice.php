<?php

namespace App\Models;

use App\Enums\Font;
use App\Models\Order;
use App\Enums\PrimaryColor;
use Database\Factories\InvoiceFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'primary_color' => PrimaryColor::class,
        'font' => Font::class,
    ];

    protected static function newFactory(): Factory
    {
        return InvoiceFactory::new();
    }


    public function primaryColor(): ?string
    {
        return $this->color;
    }

    public function font(): ?string
    {
        return $this->font;
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
