<?php

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;

if (!function_exists('base_url')) {
    function base_url($path = '') {
        return rtrim(URL::to('/'), '/') . '/' . trim($path, '/');
    }
}

if (!function_exists('current_url')) {
    function current_url() {
        return Request::fullUrl();
    }
}

if (!function_exists('uri_string')) {
    function uri_string() {
        return trim(Request::path(), '/');
    }
}

if (!function_exists('old_input')) {
    function old_input($key, $default = null) {
        return old($key, $default);
    }
}
