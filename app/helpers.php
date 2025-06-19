<?php

if (!function_exists('display_star_rating')) {
    function display_star_rating(?float $value): string
    {
        return $value !== null
            ? number_format($value, 1) . '★'
            : '-';
    }
}