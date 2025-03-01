<x-layout.dashboard>
    <div class="flex flex-col gap-8 justify-center items-center w-full h-full">
        <h2 class="text-3xl">Status Koneksi Server</h2>
        @if($status->data == "Normal")
        <h3 class="text-green-500 text-2xl">{{ $status->data }}</h3>
        @else
        <h3 class="text-red-700 text-2xl">{{ $status->data }}</h3>
        @endif

        <form action="{{ route('status-koneksi.store') }}" method="post" class="flex justify-center items-center w-full">
            @csrf

            <div class="flex justify-center items-center gap-2 w-[500px] -translate-x-10">
                <h3 class="text-red-600 text-2xl">Sedang ada Gangguan</h3>
                <button type="submit" class="relative bg-gray-400 w-20 h-6 rounded-lg">
                    @if($status->data == "Normal")
                    <div class="absolute -top-1 right-0 w-8 h-8 rounded-full bg-black"></div>
                    @else
                    <div class="absolute -top-1 left-0 w-8 h-8 rounded-full bg-black"></div>
                    @endif
                </button>
                <h3 class="text-green-600 text-2xl">Normal</h3>
            </div>
        </form>
    </div>
</x-layout.dashboard>
