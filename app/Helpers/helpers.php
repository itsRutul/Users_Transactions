<?php

if (!function_exists('minus')) {
    function minus($amount, $percentage) {
        return $amount * (1 - $percentage);
    }
}

