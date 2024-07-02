<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\ClassSchool;
use Illuminate\Http\Request;
use App\Helpers\GenerateMidSemesterRaport;

class KMMidSemesterRaportController extends Controller
{
    public function previewMidSemesterRaport(Request $request)
    {
        $livewire = json_decode($request->input('livewire'), true);
        $data = json_decode($request->input('data'), true);
        $classSchool = ClassSchool::find($data['class_school_id']);
        $date = $data['date'];
        $dateTime = new DateTime($date);
        $formattedDate = $dateTime->format('d F Y');

        $semester = $data['semester_id'];
        $term = $data['term_id'];

        return GenerateMidSemesterRaport::make($classSchool->id, $semester, $term, $formattedDate);
    }
}
