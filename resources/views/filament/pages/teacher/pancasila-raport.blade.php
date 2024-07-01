<x-filament-panels::page>
    <form wire:submit="find">
        {{ $this->form }}

        <div class="text-right">
            <x-filament::button type="submit" class="mt-2 ">
                Find
            </x-filament::button>
            @if ($saveBtn)
                <x-filament::button wire:click="save" class="mt-2" color="info" wire:dirty.remove wire:target="data">
                    Save
                </x-filament::button>
            @endif
        </div>
    </form>

    <!-- Kartu Informasi -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <x-filament::card class="col-span-1">
            <h2 class="text-lg font-semibold">MB - Mulai Berkembang</h2>
            <p>Siswa masih membutuhkan bimbingan dalam mengembangkan kemampuan.</p>
        </x-filament::card>
        <x-filament::card class="col-span-1">
            <h2 class="text-lg font-semibold">SB - Sedang Berkembang</h2>
            <p>Siswa mulai mengembangkan kemampuan namun belum baik.</p>
        </x-filament::card>
        <x-filament::card class="col-span-1">
            <h2 class="text-lg font-semibold">BSH - Berkembang Sesuai Harapan</h2>
            <p>Siswa telah mengembangkan kemampuan hingga ke tahap baik.</p>
        </x-filament::card>
        <x-filament::card class="col-span-1">
            <h2 class="text-lg font-semibold">SB - Sangat Berkembang</h2>
            <p>Siswa mengembangkan kemampuan melampaui harapan.</p>
        </x-filament::card>
    </div>

    <x-filament-tables::container>

    
        <!-- Placeholder for loading -->
        <div class="border shadow rounded-md p-4 w-full mx-auto" wire:loading wire:target="data">
            <div class="animate-pulse flex space-x-4">
                <div class="rounded-full bg-slate-700 h-10 w-10"></div>
                <div class="flex-1 space-y-6 py-1">
                <div class="h-2 bg-slate-700 rounded"></div>
                <div class="space-y-3">
                    <div class="grid grid-cols-3 gap-4">
                    <div class="h-2 bg-slate-700 rounded col-span-2"></div>
                    <div class="h-2 bg-slate-700 rounded col-span-1"></div>
                    </div>
                    <div class="h-2 bg-slate-700 rounded"></div>
                </div>
                </div>
            </div>
        </div>

        <table class="divide-y divide-gray-200 dark:divide-white/5 w-full text-center" wire:loading.remove wire:target="data">

            <thead class="divide-y-2 divide-slate-400 ">
                <tr class="divide-x bg-gray-50 dark:bg-white/5">
                    <th class="text-left p-3">
                        Elemen Profil Pelajar Pancasila
                    </th>
                    @foreach ($pancasilaRaportValueDescription as $value)
                        <th class="py-3 cursor-help" title="{{ $value->title }}"  data-popover-placement="left" data-popover-target="{{ $value->short_name }}-{{ $value->id }}">
                                {{ $value->short_name }}

                                <div data-popover id="{{ $value->short_name }}-{{ $value->id }}" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                    <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ $value->title }}</h3>
                                    </div>
                                    <div class="px-3 py-2">
                                        <p>{{ $value->description }}</p>
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>
                            
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
                @if ($PancasilaRaportProject)
                    @foreach ($PancasilaRaportProject->where('pancasila_raport_group_id',3) as $subProject)
                        <tr wire:key="{{ $subProject->id }}">
                            <td class="text-left p-2">{{$loop->iteration}}. {{ $subProject->name }}</td>
                            @foreach ($pancasilaRaportValueDescription as $value)
                                <td class="divide-y-2 divide-slate-400 p-2"></td>
                            @endforeach
                        </tr>
                        @if ($subProject->children->count())
                            @foreach ($subProject->children as $child)
                                <tr wire:key="{{ $child->id }}">
                                    <td class="child text-left p-2 indent-2">- {{ $child->name }}</td>
                                    @foreach ($pancasilaRaportValueDescription as $value)
                                        <td class="divide-y-2 divide-slate-400 p-2">
                                            <div class="" wire:dirty.remove wire:target="data">
                                                <label>
                                                    <x-filament::input.checkbox value="{{$child->id}},{{$value->id}}" wire:model.live="projectElements" wire:click="projectElement('{{$child->id}},{{$value->id}}')" />
                                                </label>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endif
                        {{-- text area input for notes name --}}
                        <tr wire:key="notes-{{ $subProject->id }}">
                            <td class="text-left p-2" colspan="{{ $pancasilaRaportValueDescription->count() + 1 }}">
                                <label for="notes-{{ $subProject->id }}" class="block text-sm font-medium text-gray-700">Notes:</label>
                                <textarea id="notes-{{ $subProject->id }}" wire:model.defer="notes.{{ $subProject->id }}" class="w-full border border-gray-300 rounded-md p-2 mt-1" placeholder="Enter notes here..."></textarea>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>

            <!-- <tfoot class="bg-gray-50 dark:bg-white/5">
                <tr>
                    <td>
                        Foo
                    </td>
                </tr>
            </tfoot> -->

        </table>
        
    </x-filament-tables::container>

</x-filament-panels::page>
