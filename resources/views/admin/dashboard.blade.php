<x-app-layout>
    <x-slot name="header">
        <h2>Admin Dashboard</h2>
    </x-slot>

    <div class="p-6">
        <h1>Admin Panel</h1>
        <p>Welcome Admin {{ auth()->user()->name }}</p>
    </div>
</x-app-layout>