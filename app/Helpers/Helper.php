<?php

namespace App\Helpers;

class Helper
{
    public static function getSex($id)
    {
        if ($id === null || $id === '') {
            return 'Unknown';
        }

        return $id == 1 ? 'Male' : 'Female';
    }

    public static function getReligion($id)
    {
        if ($id == 0) {
            return 'Islam';
        } elseif ($id == 1) {
            return 'Kristen';
        } elseif ($id == 2) {
            return 'Katolik';
        } elseif ($id == 3) {
            return 'Hindu';
        } elseif ($id == 4) {
            return 'Budha';
        } elseif ($id == 5) {
            return 'Konghucu';
        } else {
            return 'Other';
        }
    }

    public static function getMaritalStatus($id)
    {
        if ($id == 1) {
            return 'Married';
        } elseif ($id == 2) {
            return 'Single';
        } elseif ($id == 3) {
            return 'Widow';
        } elseif ($id == 4) {
            return 'Widower';
        } else {
            return 'Other';
        }
    }

    // Helper methods for converting names to IDs
    public static function getSexByName($name)
    {
        if ($name == 'Male') {
            return '1';
        } elseif ($name == 'Female') {
            return '2';
        } else {
            return null;
        }
    }

    public static function getReligionByName($name)
    {
        if ($name == 'Islam') {
            return '1';
        } elseif ($name == 'Kristen') {
            return '2';
        } elseif ($name == 'Katolik') {
            return '3';
        } elseif ($name == 'Hindu') {
            return '4';
        } elseif ($name == 'Budha') {
            return '5';
        } elseif ($name == 'Konghucu') {
            return '6';
        } else {
            return '7';
        }
    }

    public static function getMaritalStatusByName($name)
    {
        if ($name == 'Married') {
            return '1';
        } elseif ($name == 'Single') {
            return '2';
        } elseif ($name == 'Widow') {
            return '3';
        } elseif ($name == 'Widower') {
            return '4';
        } else {
            return '5';
        }
    }

    public static function getDate($date)
    {
        return date('d F Y', strtotime($date));
    }
}
