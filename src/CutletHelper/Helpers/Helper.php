<?php

namespace Va\CutletHelper\Helpers;

use Illuminate\Support\Facades\Route;

class Helper
{
    /**
     * @param int $length
     * @return int
     */
    public function integerToken($length = 5)
    {
        return mt_rand(pow(10, $length - 1), pow(10, $length) - 1);
    }

    /**
     * @param int $length
     * @param string $characters
     * @return string
     */
    public function stringToken($length = 16, $characters = '2345679acdefghjkmnpqrstuvwxyz')
    {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function digitsToEastern($number)
    {
        $western = range(0, 9);
        $eastern = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

        return str_replace($western, $eastern, $number);
    }

    public function easternToDigits($number)
    {
        $eastern = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $western = range(0, 9);

        return str_replace($eastern, $western, $number);
    }

    /**
     * @param $key
     * @param string $activeClassName
     * @return string
     */
    public function isActive($key, $activeClassName = 'active')
    {
        if(is_array($key)) {
            return in_array(Route::currentRouteName(), $key) ? $activeClassName : '';
        }
        return Route::currentRouteName() == $key ? $activeClassName : '';
    }

    public function prepareInteger($input)
    {
        return preg_replace('/[^0-9]+/', '', $input);
    }

    public function prepareSlug($slug, $title, $model)
    {
        $slug = trim($slug);
        if ($slug == null) {
            $slug = $title;
        }
        $slug = \Str::slug($slug, '-', NULL);
        $selected_slug = $slug;
        $slug_counter = 1;
        do {
            $slug_exists = $model::query()->where('slug', $selected_slug)->count();
            if ($slug_exists) {
                $selected_slug = $slug . "-" . $slug_counter++;
            }
        } while ($slug_exists);

        return $selected_slug;
    }

    public function prepareMetaDescription($input)
    {
        $stripString = strip_tags($input);
        $trimString = trim($stripString);
        $result = mb_strimwidth($trimString, 0, 160);
        return $result;
    }
}
