<?php

namespace App\Models;

use Sushi\Sushi;
use Illuminate\Database\Eloquent\Model;

class PancasilaRaportGroup extends Model
{
    use Sushi;

    protected $rows = [
        [
            'id' => 1,
            'name' => 'Tema Project',
        ],
        [
            'id' => 2,
            'name' => 'Sub-tema',
        ],
        [
            'id' => 3,
            'name' => 'Dimensi',
        ],
        [
            'id' => 4,
            'name' => 'Elemen',
        ],
    ];
}
