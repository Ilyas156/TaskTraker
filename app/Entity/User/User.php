<?php

namespace App\Entity\User;

use App\Entity\Task\Task;
use App\Enums\User\UserRolesEnum;
use App\Enums\User\UserStatusEnum;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string $verify_token
 * @property string $role
 * @property string $status
 */
final class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'last_name', 'email', 'phone', 'password', 'verify_token', 'status', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function task(): HasMany
    {
        return $this->hasMany(Task::class);
    }


    public static function register(string $name, string $email, string $password): self
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'verify_token' => Str::uuid(),
            'role' => UserRolesEnum::ROLE_USER->value,
            'status' => UserStatusEnum::STATUS_WAIT->value,
        ]);
    }

    public static function new($name, $email): self
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt(Str::random()),
            'role' => UserRolesEnum::ROLE_USER->value,
            'status' => UserStatusEnum::STATUS_ACTIVE->value,
        ]);
    }

    public function isWait(): bool
    {
        return $this->status === UserStatusEnum::STATUS_WAIT->value;
    }

    public function isActive(): bool
    {
        return $this->status === UserStatusEnum::STATUS_ACTIVE->value;
    }

    public function verify(): void
    {
        if (!$this->isWait()) {
            throw new \DomainException('User is already verified.');
        }

        $this->update([
            'status' => UserStatusEnum::STATUS_ACTIVE->value,
            'verify_token' => null,
        ]);
    }

    public function changeRole($role): void
    {
        if (!array_key_exists($role, UserRolesEnum::rolesList())) {
            throw new \InvalidArgumentException('Undefined role "' . $role . '"');
        }
        if ($this->role === $role) {
            throw new \DomainException('Role is already assigned.');
        }
        $this->update(['role' => $role]);
    }

    public function isModerator(): bool
    {
        return $this->role === UserRolesEnum::ROLE_MODERATOR->value;
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRolesEnum::ROLE_ADMIN->value;
    }


    public function hasFilledProfile(): bool
    {
        return !empty($this->name) && !empty($this->last_name) && $this->isActive();
    }
}
