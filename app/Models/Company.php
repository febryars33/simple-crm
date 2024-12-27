<?php

namespace App\Models;

use App\Concerns\Searchable;
use App\Concerns\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory, Searchable, SoftDeletes, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'phone' => E164PhoneNumberCast::class.':ID',
    ];

    /**
     * Get all of the employees for the Company
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
