<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Student extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes, Notifiable, HasRoles;

    protected $fillable = [
        'school_class_id', 'school_major_id', 'student_identification_number',
        'name', 'email', 'phone_number', 'gender', 'school_year_start',
        'school_year_end', 'password',
    ];

    /**
     * Set the guard attribute
     *
     * @var string
     */
    protected $guard_name = 'student';

    /**
     * Get school class relation data.
     *
     * @return BelongsTo
     */
    public function school_class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    /**
     * Get school major relation data.
     *
     * @return BelongsTo
     */
    public function school_major(): BelongsTo
    {
        return $this->belongsTo(SchoolMajor::class);
    }

    /**
     * Get cash transaction relation data.
     *
     * @return HasMany
     */
    public function cash_transactions(): HasMany
    {
        return $this->hasMany(CashTransaction::class);
    }

    /**
     * Get student transaction relationship
     *
     * @return BelongsTo
     */
    public function billings(): HasMany
    {
        return $this->hasMany(Bill::class);
    }

    /**
     * Get student gender name.
     *
     * @return string
     */
    public function getGenderName(): string
    {
        return match ($this->gender) {
            1 => 'Laki-laki',
            2 => 'Perempuan'
        };
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
