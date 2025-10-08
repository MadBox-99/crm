<?php

declare(strict_types=1);

namespace App\Enums;

enum NavigationGroup: string
{
    case Customers = 'Customers';
    case Sales = 'Sales';
    case Products = 'Products';
    case Marketing = 'Marketing';
    case Support = 'Support';
    case Communication = 'Communication';
    case Reports = 'Reports';
    case Settings = 'Settings';
    case System = 'System';

    public function getLabel(): string
    {
        return match ($this) {
            self::Customers => 'Ügyfelek',
            self::Sales => 'Értékesítés',
            self::Products => 'Termékek',
            self::Marketing => 'Marketing',
            self::Support => 'Ügyfélszolgálat',
            self::Communication => 'Kommunikáció',
            self::Reports => 'Riportok',
            self::Settings => 'Beállítások',
            self::System => 'Rendszer',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Customers => 'heroicon-o-user-group',
            self::Sales => 'heroicon-o-currency-dollar',
            self::Products => 'heroicon-o-cube',
            self::Marketing => 'heroicon-o-megaphone',
            self::Support => 'heroicon-o-lifebuoy',
            self::Communication => 'heroicon-o-chat-bubble-left-right',
            self::Reports => 'heroicon-o-chart-bar',
            self::Settings => 'heroicon-o-cog-6-tooth',
            self::System => 'heroicon-o-server',
        };
    }

    public function getSort(): int
    {
        return match ($this) {
            self::Customers => 10,
            self::Sales => 20,
            self::Products => 30,
            self::Marketing => 40,
            self::Support => 50,
            self::Communication => 60,
            self::Reports => 70,
            self::Settings => 80,
            self::System => 90,
        };
    }
}
