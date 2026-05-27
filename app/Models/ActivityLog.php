<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'action', 'old_values', 'new_values', 'changes_summary'];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
