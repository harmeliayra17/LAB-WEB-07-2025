@props(['title', 'image', 'description'])

<div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100">
    @if(isset($image))
    <div class="h-48 overflow-hidden">
        <img 
            src="{{ $image }}" 
            alt="{{ $title ?? 'Card image' }}" 
            class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
        >
    </div>
    @endif
    
    <div class="p-6">
        @if(isset($title))
        <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">{{ $title }}</h3>
        @endif
        
        @if(isset($description))
        <p class="text-gray-600 leading-relaxed line-clamp-3">{{ $description }}</p>
        @endif
        
        @if($slot->isNotEmpty())
        <div class="mt-4">
            {{ $slot }}
        </div>
        @endif
    </div>
</div>