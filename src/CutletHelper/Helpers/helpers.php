<?php

function integerToken($length = 5) {

    return \Va\CutletHelper\Helpers\CutletHelper::integerToken($length);
}

function stringToken($length = 16, $characters = '2345679acdefghjkmnpqrstuvwxyz') {

    return \Va\CutletHelper\Helpers\CutletHelper::stringToken($length, $characters);
}

function digitsToEastern($number) {

    return \Va\CutletHelper\Helpers\CutletHelper::digitsToEastern($number);
}

function isActive($key, $activeClassName = 'active') {

    return \Va\CutletHelper\Helpers\CutletHelper::isActive($key, $activeClassName);
}
