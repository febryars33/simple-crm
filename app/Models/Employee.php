<?php

namespace App\Models;

use App\Concerns\Searchable;
use App\Concerns\Sortable;
use App\Enums\Employee\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;

/**
 * Undocumented class
 *
 * @method static sortPagination()
 */
class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory, Searchable, SoftDeletes, Sortable;

    const ROLE_MANAGER = Role::MANAGER->value;

    const ROLE_EMPLOYEE = Role::EMPLOYEE->value;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'company_id',
        'name',
        'nik',
        'phone',
        'birth_place',
        'birth_date',
        'address',
        'role',
    ];

    public function scopeWhereCompany(Builder $builder, int $company_id)
    {
        $builder->where('company_id', $company_id);
    }

    public function scopeWhereNotManager(Builder $builder)
    {
        $builder->where('role', '!=', Role::MANAGER->value);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'birth_date' => 'date',
        'role' => Role::class,
        'phone' => E164PhoneNumberCast::class.':ID',
    ];

    /**
     * Get the company that owns the Employee
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the user that owns the Employee
     */
    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable')->withDefault(function (User $user, Employee $employee) {
            $user->id = null;
            $user->name = null;
            $user->email = null;
            $user->email_verified_at = null;
            $user->deleted_at = null;
            $user->created_at = null;
            $user->updated_at = null;
        });
    }
}
