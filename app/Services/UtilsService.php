<?php

namespace App\Services;

class UtilsService
{
    static function roundUpToNearestFive($number) {
        // Round up to the nearest integer
        // Round up to the nearest multiple of 5
        $roundedUp = ceil($number / 5) * 5;
        
        // Round the rounded up number to the nearest power of 10
        $roundedUpPowerOfTen = pow(10, ceil(log10($roundedUp)));
        
        return $roundedUpPowerOfTen;
    }
}
