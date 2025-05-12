<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('valid_domain')) {
    function valid_domain($domain) {
        return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain)
                && preg_match("/^.{1,253}$/", $domain)
                && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain));
    }
}

if (!function_exists('domain_status_badge')) {
    function domain_status_badge($expiration_date) {
        if (!$expiration_date) return '<span class="badge bg-secondary">Unknown</span>';
        
        $exp_date = new DateTime($expiration_date);
        $today = new DateTime();
        $diff = $today->diff($exp_date);
        
        if ($diff->invert == 1) {
            return '<span class="badge bg-danger">Expired ' . $diff->days . ' days ago</span>';
        } elseif ($diff->days < 7) {
            return '<span class="badge bg-danger">Expires in ' . $diff->days . ' days</span>';
        } elseif ($diff->days < 30) {
            return '<span class="badge bg-warning">Expires in ' . $diff->days . ' days</span>';
        } elseif ($diff->days < 60) {
            return '<span class="badge bg-info">Expires in ' . $diff->days . ' days</span>';
        } else {
            return '<span class="badge bg-success">Active (' . $diff->days . ' days left)</span>';
        }
    }
}