<?php
session_start();
include '../../includes/connect.php';
include '../../functions/isUserBanned.php';
include '../../functions/errorControllers.php';

$sidebarContent = '
    <ul class="space-y-4">
        <li>
            <a href="#" @click.prevent="currentPage = \'customers\'; isOpen = false" class="text-gray-900 hover:text-gray-600 flex items-center">
                <span class="material-icons mr-2">home</span>
                Home
            </a>
        </li>
        <li>
            <a href="#" @click.prevent="currentPage = \'customers\'; isOpen = false" class="text-gray-900 hover:text-gray-600 flex items-center">
                <span class="material-icons mr-2">manage_inventory</span>
                Manage Inventory
            </a>
        </li>
        <li>
            <a href="#" @click.prevent="currentPage = \'customers\'; isOpen = false" class="text-gray-900 hover:text-gray-600 flex items-center">
                <span class="material-icons mr-2">people</span>
                Controll Users
            </a>
        </li>
        <li>
            <a href="#" @click.prevent="currentPage = \'control_account\'; isOpen = false" class="text-gray-900 hover:text-gray-600 flex items-center">
                <span class="material-icons mr-2">settings</span>
                Controll Account
            </a>
        </li>
    </ul>
';

include '../../includes/header.php';
?>