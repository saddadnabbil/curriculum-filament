<?php

namespace App\Filament\Pages\Teacher;

use App\Models\User;
use App\Models\Level;
use App\Helpers\Helper;
use App\Models\Student;
use App\Models\Teacher;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Pages\Page;
use App\Models\ClassSchool;
use Filament\Actions\Action;
use App\Models\MemberClassSchool;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use App\Models\PancasilaRaportProject;
use App\Models\StudentPancasilaRaport;
use function PHPUnit\Framework\isNull;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use App\Models\PancasilaRaportProjectGroup;
use Illuminate\Database\Eloquent\Collection;
use App\Models\PancasilaRaportValueDescription;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use App\Helpers\GeneratePancasilaRaport; // Pastikan ini sudah diimpor
use Filament\Forms\Components\DatePicker;

class PrintSemesterReport extends Page
{
    // use HasPageShield;
    public ?array $data = [];
    protected ?string $heading = 'Semester Progress Raport';
    public ?array $projectElements = [];
    public ?array $masterProjectElements = [];
    public bool $saveBtn = false;
    public $notes = [];
    public ?Collection $pancasilaRaportValueDescription;
    public ?Collection $memberClassSchool;
    public ?Collection $StudentPancasilaRaport;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.teacher.print-semester-report';

    // Corrected visibility to public
    public static function getNavigationSort(): ?int
    {
        return 6;  // Adjust this number based on where you want this page in the order
    }

    public function mount(): void
    {
        $this->form->fill();
        // $this->pancasilaRaportValueDescription = PancasilaRaportValueDescription::all();
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    Select::make('class_school_id')
                        ->label('Class School')
                        ->searchable()
                        ->options(function (Get $get) {
                            return ClassSchool::where('academic_year_id', Helper::getActiveAcademicYearId())->whereNotIn('level_id', [1, 2, 3])->get()->pluck('name', 'id')->toArray();
                        })
                        ->required(),
                    Select::make('semester_id')
                        ->label('Semester')
                        ->searchable()
                        ->options(
                            [
                                1 => '1',
                                2 => '2',
                            ]
                        )
                        ->required(),
                    DatePicker::make('date')
                        ->native(false)
                        ->label('Date')
                        ->required(),
                ])->columns(3),
            ])
            ->statePath('data');
    }

    public function find(): void
    {
        $data = $this->form->getState();

        // Fetch the student IDs from MemberClassSchool where the class_school_id matches the given ID
        $studentIDs = MemberClassSchool::where('class_school_id', $data['class_school_id'])
            ->pluck('student_id');

        // Fetch the students using the IDs obtained above and assign the result to $this->memberClassSchool
        $this->memberClassSchool = Student::whereIn('id', $studentIDs)
            ->where('class_school_id', $data['class_school_id'])
            ->get();  // Call get() to execute the query and fetch the data

        $this->saveBtn = true;
    }

    public function projectElement($val)
    {
        $keepValue = $val;
        $prefix = substr($keepValue, 0, strrpos($keepValue, ',') + 1);

        foreach ($this->projectElements as $key => $value) {
            if (strpos($value, $prefix) === 0 && $value !== $keepValue) {
                unset($this->projectElements[$key]);
            }
        }

        $this->projectElements = array_values($this->projectElements);
    }

    public function save()
    {
        $data = $this->form->getState();

        return redirect()->route('preview-semester-raport', [
            'livewire' => json_encode($this),
            'data' => json_encode($data)
        ]);
    }

    public static function getNavigationGroup(): ?string
    {
        return __("menu.nav_group.report_km_homeroom");
    }
}
