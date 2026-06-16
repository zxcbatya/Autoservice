<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;

class WidgetAdminMenu extends Component
{
    public function __construct(
        private readonly array $items,
    ) {
    }

    public function render(): string
    {
        $requestUrl = request()?->getPathInfo();
        $currentRoute = request()?->route()?->getName() ?? '';

        $menu = '<ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu" data-accordion="false">';

        foreach ($this->items as $item) {
            if (isset($item['submenu'])) {
                $submenu = '';
                $openParentClass = '';
                $activeParentClass = '';
                $routePrefix = $item['route_prefix'] ?? null;

                foreach ($item['submenu'] as $subItem) {
                    $isActive = $this->isRouteActive($subItem['route'], $requestUrl, $currentRoute, $routePrefix);
                    $activeItemClass = $isActive ? 'active' : '';

                    if ($isActive) {
                        $activeParentClass = 'active';
                        $openParentClass = 'menu-open';
                    }

                    $submenu .= view('components.admin-menu._menu-item', [
                        'item' => $subItem,
                        'activeItemClass' => $activeItemClass,
                    ]);
                }

                if ($routePrefix && str_starts_with($currentRoute, $routePrefix)) {
                    $activeParentClass = 'active';
                    $openParentClass = 'menu-open';
                }

                $menu .= view('components.admin-menu._menu-item-with-children', [
                    'item' => $item,
                    'openParentClass' => $openParentClass,
                    'activeParentClass' => $activeParentClass,
                    'submenu' => $submenu,
                ]);
            } else {
                $activeItemClass = $this->isRouteActive($item['route'], $requestUrl, $currentRoute)
                    ? 'active'
                    : '';
                $menu .= view('components.admin-menu._menu-item', [
                    'item' => $item,
                    'activeItemClass' => $activeItemClass,
                ]);
            }
        }

        return $menu . '</ul>';
    }

    private function isRouteActive(
        string $routeName,
        ?string $requestUrl,
        string $currentRoute,
        ?string $routePrefix = null,
    ): bool {
        if ($currentRoute === $routeName) {
            return true;
        }

        if ($routePrefix && str_starts_with($currentRoute, $routePrefix)) {
            return $currentRoute === $routeName;
        }

        return route($routeName, [], false) === $requestUrl;
    }
}
