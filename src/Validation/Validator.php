<?php
namespace App\Validation;

class Validator {
    public static function username(string $s): bool {
        return (bool)preg_match('/^[a-zA-Z0-9]{3,16}$/', $s);
    }
    public static function email(string $s): bool {
        return (bool)filter_var($s, FILTER_VALIDATE_EMAIL);
    }
    public static function password(string $s): bool {
        $len = strlen($s) >= 6;
        $upper = preg_match('/[A-Z]/',$s);
        $lower = preg_match('/[a-z]/',$s);
        $digit = preg_match('/\d/',$s);
        return $len && $upper && $lower && $digit;
    }
    public static function phone(string $s): bool {
        return (bool)preg_match('/^[0-9\-\+\s\(\)]{5,30}$/', $s);
    }
    public static function name(string $s): bool {
        $s = trim($s);
        return $s !== '' && \mb_strlen($s) <= 100;
    }
}
