<?php

namespace App\Models;

use App\Transformers\ApplicantTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $data)
 * @method static latest()
 */
class Applicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'workstation_id',
        'message',
        'curriculum_vitae',
        'status_job'
    ];

    protected $appends = ['fullName'];

    public string $transformer = ApplicantTransformer::class;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function workstation(): BelongsTo
    {
        return $this->belongsTo(Workstation::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->user->name . ' ' . $this->user->lastname;
    }
}
