<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;
use App\Filament\Resources\RoleResource;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\PermissionResource;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Filament::serving(function() {
            //logout
            if (auth()->user()) {
                //admin
                if (auth()->user()->is_admin == 1 && auth()->user()->hasAnyRole(['super-admin','admin','moderator'])) {
                Filament::registerUserMenuItems([
                    UserMenuItem::make()
                        ->label('Profile')
                        ->url(route('profile.show'))
                        ->icon('heroicon-s-user'),
                    UserMenuItem::make()
                        ->label('Manage Users')
                        ->url(UserResource::getUrl())
                        ->icon('heroicon-s-users'),
                    UserMenuItem::make()
                        ->label('Manage Roles')
                        ->url(RoleResource::getUrl())
                        ->icon('heroicon-s-cog'),
                    UserMenuItem::make()
                        ->label('Manage Permissions')
                        ->url(PermissionResource::getUrl())
                        ->icon('heroicon-s-key'),
                ]);
            //users
            }elseif (auth()->user()->is_admin == 0) {
                Filament::registerUserMenuItems([
                    UserMenuItem::make()
                        ->label('Profile')
                        ->url(route('profile.show'))
                        ->icon('heroicon-s-user'),
                ]);
            }
            }
            
        });
    }
}
