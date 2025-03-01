<a href="{{ route($route) }}" class="flex items-center gap-2 px-2 py-1 hover:bg-red-300 {{ Route::currentRouteName() == $route ? 'bg-red-300' : '' }}">
    <img src="{{ $icon }}" alt="{{ $name }}" class="w-8 rounded {{ $border  ? 'border-[1px] border-black p-1' : ''}}">
    <span>{{ $name }}</span>
</a>
