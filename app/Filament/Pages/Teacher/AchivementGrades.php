<?php

namespace App\Filament\Pages\Teacher;

use App\Models\User;
use App\Helpers\Helper;
use App\Models\Student;
use App\Models\Teacher;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Pages\Page;
use App\Models\ClassSchool;
use Filament\Actions\Action;
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

class AchivementGrades extends Page
{
    // use HasPageShield;
    public ?array $data = [];
    protected ?string $heading = 'P5 Raport';
    public ?array $projectElements = [];
    public ?array $masterProjectElements = [];
    public bool $saveBtn = false;
    public $notes = [];
    public ?Collection $students;
    public ?Collection $PancasilaRaportProject;
    public ?Collection $StudentPancasilaRaport;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.teacher.achivement-grades';

    public function mount(): void
    {
        $this->form->fill();
        $this->students = Student::all();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    Select::make('term_id')
                        ->label('Term')
                        ->searchable()
                        ->options([
                            1 => '1',
                            2 => '2',
                            3 => '3',
                            4 => '4',
                        ])
                        ->required(),
                    Select::make('class_school_id')
                        ->label('Class School')
                        ->searchable()
                        ->options(
                            ClassSchool::where('academic_year_id', Helper::getActiveAcademicYearId())->whereIn('level_id', [1, 2, 3])->get()
                                ->pluck('name', 'id')
                                ->filter(function ($value) {
                                    return !is_null($value); // Remove null values
                                })
                                ->toArray()
                        )
                        ->required(),
                ])->columns(2),
            ])
            ->statePath('data');
    }

    public function find(): void
    {
        $data = $this->form->getState();

        $PancasilaRaportProject = $this->PancasilaRaportProject = PancasilaRaportProject::query()
            ->with('children')
            ->get();

        $childrenIds = $PancasilaRaportProject->where('pancasila_raport_group_id', 3)->flatMap(function ($parent) {
            return $parent->children->pluck('id');
        })->all();

        $StudentPancasilaRaport = $this->StudentPancasilaRaport = StudentPancasilaRaport::query()
            ->whereIn('pancasila_raport_project_id', $childrenIds)
            ->where('student_id', $data['student_id'])
            ->get();

        $this->projectElements = [];
        $this->notes = []; // Inisialisasi ulang notes

        $this->saveBtn = true;

        if ($StudentPancasilaRaport->count()) {
            foreach ($StudentPancasilaRaport as $key => $value) {
                $this->masterProjectElements[] = $this->projectElements[] = $value->pancasila_raport_project_id . ',' . $value->prv_description_id;
                // Find the corresponding sub-project ID for the child
                $subProjectId = PancasilaRaportProject::whereHas('children', function ($query) use ($value) {
                    $query->where('id', $value->pancasila_raport_project_id);
                })->value('id');

                if ($subProjectId) {
                    // Assign the note to the correct sub-project
                    $this->notes[$subProjectId] = $value->notes;
                }
            }
        }
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

    public function updatedNotes($val, $key)
    {
        $keepValue = $val;

        $this->notes[$key] = $keepValue;

        $this->notes = array_filter($this->notes);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $collection = collect(array_unique($this->masterProjectElements));

        $result = $collection->map(function ($item) {
            $parts = explode(',', $item);
            return $parts[0];
        });

        DB::beginTransaction();
        try {
            StudentPancasilaRaport::query()
                ->where('student_id', $data['student_id'])
                ->whereIn('pancasila_raport_project_id', $result->all())
                ->delete();
            foreach ($this->projectElements as $val) {
                $childId = explode(',', $val)[0]; // This is the child ID
                $descriptionId = explode(',', $val)[1];

                // Find the corresponding sub-project ID for the child
                $subProjectId = PancasilaRaportProject::whereHas('children', function ($query) use ($childId) {
                    $query->where('id', $childId);
                })->value('id');

                // Retrieve the notes for the sub-project
                $notes = isset($this->notes[$subProjectId]) ? $this->notes[$subProjectId] : null;

                // Update or create the record
                StudentPancasilaRaport::updateOrCreate(
                    [
                        'student_id' => $data['student_id'],
                        'pancasila_raport_project_id' => $childId, // This remains the child ID
                    ],
                    [
                        'prv_description_id' => $descriptionId,
                        'notes' => $notes,
                    ]
                );
            }

            DB::commit();
            Notification::make()
                ->success()
                ->title('Saved!')
                ->send();
        } catch (\Exception $msg) {
            DB::rollBack();
            Notification::make()
                ->danger()
                ->title('Failed!,' . $msg)
                ->send();
        }
    }

    public static function getNavigationGroup(): ?string
    {
        return __("menu.nav_group.report_p5");
    }
}
