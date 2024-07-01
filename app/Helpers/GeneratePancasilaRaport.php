<?php

namespace App\Helpers;

use App\Models\Student;
use App\Models\Teacher;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Models\PancasilaRaportProject;

class GeneratePancasilaRaport
{
    public static function make(array $livewire, array $data)
    {
        $student = Student::find($livewire['data']['student_id']);
        $pancasilaRaportValueDescription = $livewire['pancasilaRaportValueDescription'];
        $PancasilaRaportProject = PancasilaRaportProject::whereIn('id', $data['PancasilaRaportProject'])->get();
        $ttd = Teacher::find($livewire['data']['teacher_id'])->employee->fullname;
        $title = 'PANCASILA RAPORT';

        $view = 'print.print-pancasila-raport-p5';

        $pdf = Pdf::loadView(
            $view,
            compact('title', 'student', 'pancasilaRaportValueDescription', 'PancasilaRaportProject', 'ttd')
        )->setPaper('A4', 'portrait'); // Use A4 paper size

        return $pdf->stream('pancasila-raport_' . $student->student_name . '.pdf');
    }
}
