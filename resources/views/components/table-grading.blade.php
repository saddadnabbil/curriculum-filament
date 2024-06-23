<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th rowspan="2" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
            <th rowspan="2" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
            <th colspan="3" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Formatif (F)</th>
            <th colspan="3" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sumatif (S)</th>
            <th rowspan="2" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Raport</th>
            <th rowspan="2" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akhir</th>
            <th rowspan="2" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revisi</th>
        </tr>
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">(F) F1T1</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">(F) F2T1</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NA (F)</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">(S) S1</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">(S) S2</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NA (S)</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        {{ $slot }}
    </tbody>
</table>
