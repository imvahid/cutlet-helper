<?php

function integerToken($length = 5) {

    return CutletHelper::integerToken($length);
}

function stringToken($length = 16, $characters = '2345679acdefghjkmnpqrstuvwxyz') {

    return CutletHelper::stringToken($length, $characters);
}

function digitsToEastern($number) {

    return CutletHelper::digitsToEastern($number);
}

function isActive($key, $activeClassName = 'active') {

    return CutletHelper::isActive($key, $activeClassName);
}
