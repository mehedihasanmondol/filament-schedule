<?php
    use App\Models\SiteSetting;

    if (!function_exists('get_activations_enums')) {
        function get_activations_enums(): array {
            return [
                'active' => 'Active',
                'inactive' => 'Inactive',
                'pending' => 'Pending',
                'suspended' => 'Suspended',
                'expired' => 'Expired',
                'deleted' => 'Deleted',
            ];
        }
    }


    if (!function_exists('get_site_setting')) {
        function get_site_setting($key, $default = null)
        {
            return SiteSetting::query()->value($key) ?? $default;
        }
    }
