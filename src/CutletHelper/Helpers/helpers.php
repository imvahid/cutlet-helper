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

function easternToDigits($number) {

    return CutletHelper::easternToDigits($number);
}

function isActive($key, $activeClassName = 'active') {

    return CutletHelper::isActive($key, $activeClassName);
}

function prepareInteger($input) {

    return CutletHelper::prepareInteger($input);
}

function prepareSlug($slug, $title, $model) {

    return CutletHelper::prepareSlug($slug, $title, $model);
}

function prepareMetaDescription($input) {
    return CutletHelper::prepareMetaDescription($input);
}

function modelNamespace($model) {
    return CutletHelper::modelNamespace($model);
}
