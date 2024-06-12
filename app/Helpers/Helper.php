<?php

namespace App\Helpers;

class Helper
{
    public static function getSex($id)
    {
        return $id == 0 ? "Male" : "Female";
    }

    public static function getSexByName($name)
    {
        if ($name == "Male") {
            return 0;
        } elseif ($name == "Female") {
            return 1;
        } else {
            return null;
        }
    }

    public static function getReligion($id)
    {
        // Islam
        // Kristen 
        // Katolik 
        // Hindu
        // Budha 
        // Konghucu 
        // Lainnya (Other)
        if ($id == 0) {
            return "Islam";
        } elseif ($id == 1) {
            return "Kristen";
        } elseif ($id == 2) {
            return "Katolik";
        } elseif ($id == 3) {
            return "Hindu";
        } elseif ($id == 4) {
            return "Budha";
        } elseif ($id == 5) {
            return "Konghucu";
        } else {
            return "Other";
        }
    }

    public static function getMaritalStatus($id)
    {
        if ($id == 0) {
            return "Married";
        } elseif ($id == 1) {
            return "Single";
        } elseif ($id == 2) {
            return "Widow";
        } elseif ($id == 3) {
            return "Widower";
        } else {
            return "Other";
        }
    }

    public static function getDate($date)
    {
        return date('d F Y', strtotime($date));
    }
}
