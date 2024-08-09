@props(['thead', 'tbody'])

<table
    {{ $attributes->class(['min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600'])->merge(['id' => 'dataTables']) }}>
    <thead class="bg-gray-100 dark:bg-gray-700">
        {{ $thead }}

    </thead>
    <tbody
        {{ $tbody->attributes->class(['text-red bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700 relative']) }}>
        {{ $tbody }}

    </tbody>

</table>
