<?php

if (!function_exists('convertFractionToClassName')) {
    /**
     * Converts a fraction string (e.g., "1/3") to a class name like "column-1-3".
     *
     * @param string $fraction
     * @return string
     */
    function convertFractionToClassName($fraction)
    {
        $fractionParts = explode('/', $fraction);

        if (count($fractionParts) === 2 && is_numeric($fractionParts[0]) && is_numeric($fractionParts[1]) && $fractionParts[1] != 0) {
            // $percentage = ($fractionParts[0] / $fractionParts[1]) * 100;
            // $roundedPercentage = floor($percentage);
            return "column-$fractionParts[0]-$fractionParts[1]";
        } else {
            return 'column-1';
        }
    }
}