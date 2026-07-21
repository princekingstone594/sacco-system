@php
    $apkUrl = config('sacco.apk_url') ?: route('apk.download');
@endphp

<a href="{{ $apkUrl }}"
   @unless (config('sacco.apk_url')) download @endunless
   aria-label="Download Royalty Sacco mobile app"
   class="group fixed bottom-6 right-6 z-50 flex h-14 w-14 items-center justify-center rounded-full bg-[#f1cc4b] text-[#241f2f] shadow-lg shadow-[#241f2f]/25 ring-4 ring-white/90 transition hover:scale-110 hover:bg-[#e1bb37] hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-[#4b2673]/40">
    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
    </svg>
    <span class="pointer-events-none absolute -top-10 right-0 whitespace-nowrap rounded-md bg-[#241f2f] px-3 py-1.5 text-xs font-bold text-white opacity-0 shadow-md transition group-hover:opacity-100 group-focus:opacity-100">
        Download App
    </span>
</a>
