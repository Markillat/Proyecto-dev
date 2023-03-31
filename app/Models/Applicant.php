<?php

namespace App\Models;

use App\Transformers\ApplicantTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'curriculum_vitae',
        'send_status'
    ];

    public $transformer = ApplicantTransformer::class;

    //Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
