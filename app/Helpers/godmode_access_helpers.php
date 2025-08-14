<?php

use CodeIgniter\Config\Services;

if (!function_exists('check_access')) {
    function check_access(string $section, string $content, string $menu): string
    {
        $session = session();
        $user = $session->get('logged_user');

        if (!$user) {
            return redirect()->to('godmode/auth/signin');
        }

        // Superadmin has full access
        if ($user->role === 'superadmin') {
            return $content;
        }

        $access = json_decode($user->access, true);

        if (!is_array($access)) {
            return 'godmode/layout/no-access';
        }

        // Only check the specific menu
        if (isset($access[$menu]) && is_array($access[$menu])) {
            if (in_array($section, $access[$menu], true)) { // strict check
                return $content;
            }
        }

        // Section not found or menu does not exist
        return 'godmode/layout/no-access';
    }
}

