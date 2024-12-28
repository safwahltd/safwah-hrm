<?php


namespace App\Helpers;


class helpers
{
    public static function numberToWords($num) {
        $a = [
            '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten',
            'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        ];
        $b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
        $g = ['', 'thousand', 'million', 'billion', 'trillion'];

        if ($num < 0 || $num > 9999999999) {
            return 'number out of range';
        }

        if ($num == 0) return 'zero';
        if ($num < 20) return $a[$num];

        $thousands = floor($num / 1000);
        $Thousandfirst_character = substr($thousands, 0, 2);
        $num = $num - ($thousands*1000);
        $hundreds = floor($num / 100);
        $first_character = substr($hundreds, 0, 1);
        $remainder = $num % 100;

        $words = [];
        if ($thousands < 20) {
            $words[] = $a[$thousands] . ' thousand';
        }
        else{
            $Thousandfirst_character = substr($thousands, 0, 1);
            $Thousand2nd_character = substr($thousands, 1, 2);
            $words[] = $b[$Thousandfirst_character].$a[$Thousand2nd_character] . ' thousand';
        }

        if ($hundreds > 0) {
            $words[] = $a[$first_character] . ' hundred';
        }

        if ($remainder < 20) {
            $words[] = $a[$remainder];
        } else {
            $tens = floor($remainder / 10);
            $units = $remainder % 10;
            $words[] = $b[$tens];
            if ($units > 0) {
                $words[] = $a[$units];
            }
        }

        return implode(' ', $words);
    }
}
