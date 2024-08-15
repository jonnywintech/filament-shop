<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appearance extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'primary_color',
        'font',
        'table_sort_direction',
        'records_per_page',
        'created_by',
        'updated_by',
    ];

}
