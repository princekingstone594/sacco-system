<a href="{{ $href ?? '#' }}"
   {{ $attributes->merge([
        'class' => 'block text-center py-2 rounded-lg font-medium transition hover:scale-105'
   ]) }}>
    {{ $slot }}
</a>