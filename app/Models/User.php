<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Permission as PermissionEnum;
use App\Enums\Role as RoleEnum;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

final class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles {
        hasRole as protected traitHasRole;
        hasAnyRole as protected traitHasAnyRole;
        hasAllRoles as protected traitHasAllRoles;
        assignRole as protected traitAssignRole;
        givePermissionTo as protected traitGivePermissionTo;
    }
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole(mixed $role, ?string $guard = null): bool
    {
        if ($role instanceof RoleEnum) {
            $role = $role->value;
        }

        return $this->traitHasRole($role, $guard);
    }

    /**
     * Check if user has any of the given roles.
     */
    public function hasAnyRole(mixed $roles, ?string $guard = null): bool
    {
        if (is_array($roles)) {
            $roles = array_map(
                fn ($role) => $role instanceof RoleEnum ? $role->value : $role,
                $roles
            );
        }

        return $this->traitHasAnyRole($roles, $guard);
    }

    /**
     * Check if user has all of the given roles.
     */
    public function hasAllRoles(mixed $roles, ?string $guard = null): bool
    {
        if (is_array($roles)) {
            $roles = array_map(
                fn ($role) => $role instanceof RoleEnum ? $role->value : $role,
                $roles
            );
        }

        return $this->traitHasAllRoles($roles, $guard);
    }

    /**
     * Assign the given role to the user.
     */
    public function assignRole(RoleEnum|string ...$roles): static
    {
        $roleValues = array_map(
            fn (RoleEnum|string $role) => $role instanceof RoleEnum ? $role->value : $role,
            $roles
        );

        $this->traitAssignRole(...$roleValues);

        return $this;
    }

    /**
     * Give the user the given permission.
     */
    public function givePermissionTo(mixed ...$permissions): static
    {
        $permissionValues = array_map(
            fn ($permission) => $permission instanceof PermissionEnum ? $permission->value : $permission,
            $permissions
        );

        $this->traitGivePermissionTo(...$permissionValues);

        return $this;
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
