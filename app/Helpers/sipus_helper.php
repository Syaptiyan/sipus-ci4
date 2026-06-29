<?php

if (!function_exists('format_tanggal')) {
    function format_tanggal($date)
    {
        if (!$date || $date === '0000-00-00') return '-';
        $months = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $t = strtotime($date);
        return date('j', $t) . ' ' . $months[(int)date('n', $t)] . ' ' . date('Y', $t);
    }
}

if (!function_exists('format_datetime')) {
    function format_datetime($datetime)
    {
        if (!$datetime) return '-';
        return format_tanggal($datetime) . ' ' . date('H:i', strtotime($datetime));
    }
}

if (!function_exists('format_rupiah')) {
    function format_rupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('active_menu')) {
    function active_menu($segment, $value)
    {
        return $segment === $value ? 'active' : '';
    }
}

if (!function_exists('limit_text')) {
    function limit_text($text, $limit = 100)
    {
        if (strlen($text) <= $limit) return $text;
        return substr($text, 0, $limit) . '...';
    }
}

if (!function_exists('generate_kode')) {
    function generate_kode($prefix, $lastId)
    {
        return $prefix . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
    }
}
