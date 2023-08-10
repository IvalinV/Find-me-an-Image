<?php

namespace App\Providers;

use Native\Laravel\Facades\ContextMenu;
use Native\Laravel\Facades\Dock;
use Native\Laravel\Facades\Window;
use Native\Laravel\Facades\GlobalShortcut;
use Native\Laravel\Facades\MenuBar;
use Native\Laravel\Menu\Menu;

class NativeAppServiceProvider
{
    public function boot(): void
    {
        // Window::open('test')
        // ->route('joke')
        // ->showDevTools(false)
        // ->height(1200)
        // ->width(1200);

        MenuBar::create()
        ->showDockIcon()
        ->label('Test')
        ->route('register')
        ->height(500)
        ->width(500);
    }
}
