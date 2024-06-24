<?php

namespace App\Providers;

use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\ServiceProvider;
use Filament\Tables\Enums\FiltersLayout;
use BezhanSalleh\PanelSwitch\PanelSwitch;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Table::configureUsing(function (Table $table): void {
            $table
                ->emptyStateHeading('No data nyet')
                ->striped()
                ->defaultPaginationPageOption(10)
                ->paginated([10, 25, 50, 100])
                ->extremePaginationLinks()
                ->defaultSort('created_at', 'desc');
        });

        PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
            $panelSwitch->modalHeading('Available Panels')
                ->modalWidth('sm')
                ->slideOver()
                ->icons([
                    'admin' => 'heroicon-o-square-2-stack',
                    'admission' => 'heroicon-o-square-2-stack',
                    'curriculum' => 'heroicon-o-square-2-stack',
                    'teacher' => 'heroicon-o-square-2-stack',
                    'teacher-pg-kg' => 'heroicon-o-square-2-stack',
                ])
                ->iconSize(15)
                ->labels([
                    'admin' => 'Admin',
                    'admission' => 'Admission',
                    'curriculum' => 'Curriculum',
                    'teacher' => 'Teacher',
                    'teacher-pg-kg' => 'Teacher PG-KG',
                ]);

            $panelSwitch->excludes(function () {
                $user = auth()->user();

                if ($user) {
                    $excludedPanels = [];

                    // Jika user memiliki permission 'can_access_panel_admin'
                    if (!$user->can('can_access_panel_admin')) {
                        $excludedPanels[] = 'admin';
                    }

                    // Jika user memiliki permission 'can_access_panel_curriculum'
                    if (!$user->can('can_access_panel_curriculum')) {
                        $excludedPanels[] = 'curriculum';
                    }

                    // Jika user memiliki permission 'can_access_panel_admission'
                    if (!$user->can('can_access_panel_admission')) {
                        $excludedPanels[] = 'admission';
                    }

                    // Jika user memiliki permission 'can_access_panel_teacher'
                    if (!$user->can('can_access_panel_teacher')) {
                        $excludedPanels[] = 'teacher';
                    }

                    // Jika user memiliki permission 'can_access_panel_teacher_pg_kg'
                    if (!$user->can('can_access_panel_teacher_pg_kg')) {
                        $excludedPanels[] = 'teacher-pg-kg';
                    }

                    return $excludedPanels;
                }

                // User yang tidak terautentikasi tidak dapat mengakses panel manapun
                return ['admin', 'curriculum', 'admission', 'teacher', 'teacher_pg_kg'];
            });
        });
    }
}
