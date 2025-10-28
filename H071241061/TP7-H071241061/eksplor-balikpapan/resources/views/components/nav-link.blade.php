@props(['active' => false])

<a {{ $attributes->merge([
    'class' => ($active ?? false)
        ? 'inline-block px-4 py-2 rounded-lg font-semibold bg-white text-blue-600 shadow-md transition-all duration-300'
        : 'inline-block px-4 py-2 rounded-lg font-semibold text-white bg-blue-500 hover:bg-blue-400 hover:shadow-md transition-all duration-300'
]) }}>
    {{ $slot }}
</a>