<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function hasrole(string $role): bool
    {
        return $this->role == $role;
    }
    public function createdTransaction(): HasMany
    {
        return $this->hasMany(Transaction::class, "created_by_user_id");
    }
    public function approvedTransaction(): HasMany
    {
        return $this->hasMany(Transaction::class, "approved_by_user_id");
    }
    public function receivedRestockOrders(): HasMany
    {
        return $this->hasMany(RestockOrder::class, "supplier_id");
    }
    public function createdRestockOrders(): HasMany
    {
        return $this->hasMany(RestockOrder::class, "created_by_user_id");
    }

}
