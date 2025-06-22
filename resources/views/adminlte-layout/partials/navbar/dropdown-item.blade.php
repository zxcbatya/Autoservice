@inject('menuItemHelper', 'JeroenNoten\LaravelAdminLte\Helpers\MenuItemHelper')

@if ($menuItemHelper->isSubmenu($item))

    {{-- Dropdown submenu --}}
    @include('adminlte-layout.partials.navbar.dropdown-item-submenu')

@elseif ($menuItemHelper->isLink($item))

    {{-- Dropdown link --}}
    @include('adminlte-layout.partials.navbar.dropdown-item-link')

@endif
