<?php

function getSidebarMenu($role) {
    $menus = [
        'admin' => [
            ['title' => 'Home', 'icon' => 'fas fa-home', 'link' => '/pages/admin/dashboard.php'],
            ['title' => 'Manage Inventory', 'icon' => 'fas fa-box-open', 'link' => '/pages/admin/manage_inventory.php'],
            ['title' => 'Manage User', 'icon' => 'fas fa-cogs', 'link' => '/pages/admin/manage_users.php'],
            ['title' => 'Report', 'icon' => 'fas fa-boxes', 'link' => '/pages/admin/report.php']
        ],
        'staff' => [
            ['title' => 'Home', 'icon' => 'fas fa-home', 'link' => '/pages/staff/dashboard.php'],
            ['title' => 'Inventory', 'icon' => 'fas fa-box-open', 'link' => '/pages/staff/view_inventory.php'],
            ['title' => 'Add Inventory', 'icon' => 'fas fa-plus', 'link' => '/pages/staff/add_inventory.php']
        ],
        'user' => [
            ['title' => 'Home', 'icon' => 'fas fa-home', 'link' => '/pages/user/dashboard.php'],
            ['title' => 'Inventory', 'icon' => 'fas fa-box-open', 'link' => '/pages/user/view_inventory.php']
        ]
    ];
    
    return $menus[$role] ?? [];
}

?>
