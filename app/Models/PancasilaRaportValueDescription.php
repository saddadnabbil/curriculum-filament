<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PancasilaRaportValueDescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
    ];

    public function getShortNameAttribute(): string
    {
        // Memisahkan string menjadi kata-kata
        $words = explode(' ', $this->title);
        $shortname = '';

        // Mengambil huruf pertama dari setiap kata
        foreach ($words as $word) {
            // Menambahkan huruf pertama ke shortname, jika ada
            if (isset($word[0])) {
                $shortname .= strtoupper($word[0]);
            }
        }

        return $shortname;
    }
}
