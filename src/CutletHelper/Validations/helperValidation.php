<?php

use Illuminate\Support\Facades\Validator;

/**
 *
 * Validate Iranian National Code
 *
 * @param $attribute
 * @param $code
 * @param $parameters
 * @return bool
 */
Validator::extend('national_code', function ($attribute, $code, $parameters, $validator) {
    if (empty($code)) {
        return true;
    }
    $sum = 0;

    $invalidCodes = [
        '0000000000',
        '1111111111',
        '2222222222',
        '3333333333',
        '4444444444',
        '5555555555',
        '6666666666',
        '7777777777',
        '8888888888',
        '9999999999'
    ];

    // Check for invalid codes
    if ($code < 1 || in_array($code, $invalidCodes)) {
        return false;
    }

    // Add zero to first of code if needed
    $code = str_pad($code, 10, '0', STR_PAD_LEFT);

    // Select control digit
    $check_number = substr($code, 9, 1);

    // Multiply the sum of the numbers 2 to 10 positions are calculated
    $multiplication = 2;
    for ($i = 8; $i >= 0; $i--) {
        $sum += substr($code, $i, 1) * $multiplication++;
    }

    $remain = $sum % 11;

    // Check code
    if (($remain < 2 && $check_number == $remain) || ($remain >= 2 && $check_number == (11 - $remain))) {
        return true;
    } else {
        return false;
    }
}, config('cutlet-helper.national_code'));

/**
 *
 * Validate IBAN (Sheba) account number
 *
 * @param $attribute
 * @param $account
 * @param $parameters
 * @return bool
 */
Validator::extend('iban', function ($attribute, $account, $parameters, $validator) {
    $account_number = $account;

    // The codes of IBAN standard characters
    $character_map = [
        10 => 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
    ];

    // Check for account country code and add if there is no exists
    if (!empty($parameters[0]) && $parameters[0] == 'false') {
        if (isset($parameters[1]) && strlen($parameters[1]) == 2) {
            $account_number = $parameters[1] . $account;
        } else {
            $account_number = 'IR' . $account;
        }
    }

    // Validate length of IBAN digits
    $iban_digits = substr($account_number, 2);
    if (!is_numeric($iban_digits) || strlen($iban_digits) != 24) {
        return false;
    }

    // Convert country characters to digit
    $country_chracters = substr($account_number, 0, 2);
    $characters_code = array_map(function ($chr) use ($character_map) {
        return array_search(strtoupper($chr), $character_map);
    }, str_split($country_chracters));
    $country_code = implode('', $characters_code);

    // Place country digits to end of account number
    $new_iban_number = substr($iban_digits, 2) . $country_code . substr($iban_digits, 0, 2);

    // Check the mod
    $check_digits = bcmod($new_iban_number, 97);

    // Finally, return the validation result
    return (int)$check_digits === 1 ? true : false;
}, config('cutlet-helper.iban'));


/**
 *
 * Validate Iranian debit card numbers
 *
 * @param $attribute
 * @param $account
 * @param $parameters
 * @return bool
 */
Validator::extend('debit_card', function ($attribute, $card_number, $parameters, $validator) {
    $card_length = strlen($card_number);
    if ($card_length < 16 || substr($card_number, 1, 10) == 0 || substr($card_number, 10, 6) == 0) {
        return false;
    }

    $banks_names = [
        'bmi' => '603799',
        'banksepah' => '589210',
        'edbi' => '627648',
        'bim' => '627961',
        'bki' => '603770',
        'bank-maskan' => '628023',
        'postbank' => '627760',
        'ttbank' => '502908',
        'enbank' => '627412',
        'parsian-bank' => '622106',
        'bpi' => '502229',
        'karafarinbank' => '627488',
        'sb24' => '621986',
        'sinabank' => '639346',
        'sbank' => '639607',
        'shahr-bank' => '502806',
        'bank-day' => '502938',
        'bsi' => '603769',
        'bankmellat' => '610433',
        'tejaratbank' => '627353',
        'refah-bank' => '589463',
        'ansarbank' => '627381',
        'mebank' => '639370',
    ];

    if (isset($parameters[0]) && (!isset($banks_names[$parameters[0]]) || substr($card_number, 0, 6) != $banks_names[$parameters[0]])) {
        return false;
    }

    $c = (int)substr($card_number, 15, 1);
    $s = 0;
    $k = null;
    $d = null;
    for ($i = 0; $i < 16; $i++) {
        $k = ($i % 2 == 0) ? 2 : 1;
        $d = (int)substr($card_number, $i, 1) * $k;
        $s += ($d > 9) ? $d - 9 : $d;
    }

    return (($s % 10) == 0);
}, config('cutlet-helper.debit_card'));


/**
 *
 * Validate Iranian Postal Code
 *
 * @param $attribute
 * @param $code
 * @param $parameters
 * @return bool
 */
Validator::extend('postal_code', function ($attribute, $code, $parameters, $validator) {
    $status = (bool)preg_match("/\b(?!(\d){3})[13-9]{4}[1346-9][013-9]{5}\b/", $code);

    return $status;
}, config('cutlet-helper.postal_code'));


/**
 *
 * Validate Iranian Shenase Meli
 *
 * @param $attribute
 * @param $value
 * @param $parameters
 * @return bool
 */
Validator::extend('shenase_meli', function ($attribute, $value, $parameters, $validator) {
    if (!is_numeric($value) || strlen($value) != 11)
        return false;
    $arrayNumbers = str_split($value);
    $controlNumber = $arrayNumbers[10];
    unset($arrayNumbers[10]);
    $constPlus = $arrayNumbers[9] + 2;
    $constCross = [29, 27, 23, 19, 17, 29, 27, 23, 19, 17];
    $i = 0;
    $sum = 0;
    foreach ($constCross as $constCrs) {
        $sum = (($arrayNumbers[$i] + $constPlus) * $constCrs) + $sum;
        $i++;
    }
    $remaining = $sum % 11;
    if ($remaining == 10)
        $remaining = 0;
    if ($remaining == $controlNumber)
        return true;
    else
        return false;
}, config('cutlet-helper.shenase_meli'));

/**
 *
 * Validate Iranian Mobile Number
 *
 * @param $attribute
 * @param $code
 * @param $parameters
 * @return bool
 */
Validator::extend('mobile', function ($attribute, $code, $parameters, $validator) {
    $status = (bool)preg_match("/^09\d{9}$/", $code);

    return $status;
}, config('cutlet-helper.mobile'));

/**
 *
 * Validate Username With English Characters
 *
 * @param $attribute
 * @param $code
 * @param $parameters
 * @return bool
 */
Validator::extend('username', function ($attribute, $code, $parameters, $validator) {
    $status = (bool)preg_match("/^[A-Za-z0-9]+(?:[_][A-Za-z0-9]+)*$/", $code);

    return $status;
}, config('cutlet-helper.username'));

/**
 *
 * Validate Iranian Phone Number
 *
 * @param $attribute
 * @param $code
 * @param $parameters
 * @return bool
 */
Validator::extend('phone', function ($attribute, $code, $parameters, $validator) {
    $status = (bool)preg_match("/^0[1-8]{2}[0-9]{8}$/", $code);

    return $status;
}, config('cutlet-helper.phone'));

/**
 *
 * Validate, Check if the two columns together are the unique or no
 *
 * @param $attribute
 * @param $code
 * @param $parameters
 * @return bool
 */
Validator::extend('unique_dynamic', function ($attribute, $value, $parameters, $validator) {
    /*
     * $parameters[0] = table_name      => fields
     * $parameters[1] = target_column   => name
     * $parameters[2] = extra_column    => type
     * $parameters[3] = extra_value     => 'text'
     * $parameters[4] = ignore_column   => 'id'
     * $parameters[5] = ignore_value    => 5
     */

    $table_name = $parameters[0];
    $target_column = $parameters[1];
    $extra_column = $parameters[2];
    $extra_value = $parameters[3];
    $ignore_column = $parameters[4] ?? null;
    $ignore_value = $parameters[5] ?? null;

    $query = \Illuminate\Support\Facades\DB::table($table_name)
        ->where($target_column, $value)
        ->where($extra_column, $extra_value);

    if( ! ($ignore_column == null && $ignore_value == null) ) {
        $ignore = \Illuminate\Support\Facades\DB::table($table_name)
            ->where($target_column, $value)
            ->where($extra_column, $extra_value)
            ->where($ignore_column, $ignore_value)
            ->exists();
        if ($ignore) {
            return true;
        }
    }

    return !$query->exists();

}, config('cutlet-helper.unique_dynamic'));

/**
 *
 * Validate Iranian Alphabetic without number
 *
 * @param $attribute
 * @param $character
 * @param $parameters
 * @return bool
 */
Validator::extend('persian_alphabetic', function ($attribute, $character, $parameters, $validator) {
    $status = (bool)preg_match("/^[\x{0621}-\x{0628}]+$|[\x{062A}-\x{063A}]+$|[\x{0641}-\x{0642}]+$|[\x{0644}-\x{0648}]+$|[\x{064E}-\x{0651}]+$|[\x{0655}\x{067E}\x{0686}\x{0698}\x{06A9}\x{06AF}\x{06BE}\x{06CC}]+$|^$/u", $character);

    return $status;
}, config('cutlet-helper.persian_alphabetic'));

/**
 *
 * Validate Iranian numbers
 *
 * @param $attribute
 * @param $character
 * @param $parameters
 * @return bool
 */
Validator::extend('persian_number', function ($attribute, $character, $parameters, $validator) {
    $status = (bool)preg_match("/^[\x{06F0}-\x{06F9}]+$|^$/u", $character);

    return $status;
}, config('cutlet-helper.persian_number'));
