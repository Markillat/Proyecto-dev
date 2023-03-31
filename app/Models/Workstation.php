<?php

namespace App\Models;

use App\Transformers\WorkstationTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workstation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'salary',
        'requirements',
        'publication_date',
        'closing_date',
        'status'
    ];

    protected $casts = [
        'publication_date' => 'date',
        'closing_date' => 'date'
    ];
    public $transformer = WorkstationTransformer::class;

}
