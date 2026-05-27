<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'user_accounts';

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
        'degree_id',
        'force_password_change',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'force_password_change' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('teacher_role', function (Builder $builder) {
            $builder->where('role', 'teacher');
        });

        static::creating(function (Teacher $teacher) {
            $teacher->role = 'teacher';
        });
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'teacher_id');
    }

    public function degree(): BelongsTo
    {
        return $this->belongsTo(Degree::class, 'degree_id');
    }
}
