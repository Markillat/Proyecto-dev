<?php

namespace App\Models;

use App\Transformers\WorkstationTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static latest()
 * @method static inRandomOrder()
 * @method static create(array $all)
 */
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

    public string $transformer = WorkstationTransformer::class;

    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class);
    }
}
