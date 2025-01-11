<?php

// app/Models/Job.php

namespace App\Models;

use App\Enums\JobTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Job extends Model
{
    use HasFactory, SoftDeletes, Searchable;
    protected $fillable = [
        'title',
        'description',
        'location',
        'salary',
        'type'
    ];

    protected $casts = [
        'type' => JobTypeEnum::class,
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'salary' => $this->salary,
        ];
    }


}
