<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
        'degree_id',
        'force_password_change',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'balance' => 'decimal:2',
        'force_password_change' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the account.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all students enrolled by this teacher (if this is a teacher account).
     */
    public function enrolledStudents()
    {
        return $this->hasMany(Student::class, 'teacher_id');
    }

    /**
     * Get the degree that this teacher teaches (if this is a teacher account).
     */
    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }
}
