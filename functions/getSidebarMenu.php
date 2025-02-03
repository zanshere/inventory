<?

function getSidebarMenu($role) {
    $menus = [
        'admin' => [
            ['title' => 'Home', 'icon' => 'fi fi-rs-home', 'link' => '/pages/admin/dashboard.php'],
            ['title' => 'Products', 'icon' => 'fi fi-rs-boxes', 'link' => '/pages/admin/manage_products.php'],
            ['title' => 'Inventory', 'icon' => 'fi fi-rs-box-open', 'link' => '/pages/admin/manage_inventory.php'],
            ['title' => 'Orders', 'icon' => 'fi fi-rs-shopping-cart', 'link' => '/pages/admin/manage_orders.php'],
            ['title' => 'Customers', 'icon' => 'fi fi-rs-users', 'link' => '/pages/admin/manage_customers.php'],
            ['title' => 'Control Account', 'icon' => 'fi fi-rs-settings', 'link' => '/pages/admin/control_account.php']
        ],
        'staff' => [
            ['title' => 'Home', 'icon' => 'fi fi-rs-home', 'link' => '/pages/staff/dashboard.php'],
            ['title' => 'Inventory', 'icon' => 'fi fi-rs-box-open', 'link' => '/pages/staff/view_inventory.php'],
            ['title' => 'Add Inventory', 'icon' => 'fi fi-rs-plus', 'link' => '/pages/staff/add_inventory.php']
        ],
        'user' => [
            ['title' => 'Home', 'icon' => 'fi fi-rs-home', 'link' => '/pages/user/dashboard.php'],
            ['title' => 'Inventory', 'icon' => 'fi fi-rs-box-open', 'link' => '/pages/user/view_inventory.php']
        ]
    ];
    
    return $menus[$role] ?? [];
}

?>