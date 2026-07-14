<div class="bg-gray-800 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-900 text-gray-400">
            <tr>
                {{ $head }}
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-700">
            {{ $slot }}
        </tbody>
    </table>
</div>