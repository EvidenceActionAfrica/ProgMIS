<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function MROUND($number,$multiple) {
    if ((is_numeric($number)) && (is_numeric($multiple))) {
        if ($multiple == 0) {
            return 0;
        }
        if ((SIGNTest($number)) == (SIGNTest($multiple))) {
            $multiplier = 1 / $multiple;
            return round($number * $multiplier) / $multiplier;
        }
        return 'NAN';
    }
    return 'NAN';
}   //  function MROUND()

function SIGNTest($number) {
    if (is_bool($number))
        return (int) $number;
    if (is_numeric($number)) {
        if ($number == 0.0) {
            return 0;
        }
        return $number / abs($number);
    }
    return 'NAN';
}   //  function SIGN()

?>