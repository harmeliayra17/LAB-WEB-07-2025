@props(['href' => '#'])

<a 
    href="{{ $href }}" 
    {{ $attributes->merge(['class' => 'inline-block px-8 py-4 text-white font-semibold rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300']) }}
    style="background-color: #D8C0AA; color: #264D52;"
    onmouseover="this.style.backgroundColor='#C59F82'"
    onmouseout="this.style.backgroundColor='#D8C0AA'"
>
    {{ $slot }}
</a>