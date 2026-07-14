<div {{ $attributes->merge(['class' => 'bg-gray-800 rounded-xl p-5 shadow-sm']) }}>
    @if(isset($title))
        <h3 class="text-sm text-gray-400 mb-3">{{ $title }}</h3>
    @endif

    {{ $slot }}
</div>