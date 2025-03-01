<x-layout.dashboard>
    <main id="main-container" class="flex flex-col items-center gap-4 p-8 w-full">
        <header class="flex flex-col justify-center items-center gap-2">
            <img src="{{ asset('images/kasir-koordinator.png') }}" alt="Gambar Koordinator">
            <h1 class="text-2xl">KASIR / KOORDINATOR / MITRA</h1>
        </header>

        <a href="{{ route('kasir.create') }}" class="self-start bg-orange-600 py-1 px-3 text-2xl font-bold">TAMBAH</a>

        <div class="self-start w-full">
            <ul class="flex flex-col gap-2 w-full">
                @foreach($kasir as $data)
                <li class="bg-white p-2 w-full">
                    <div class="flex justify-between w-full">
                        <div>
                            <span>{{ $data->nama }}</span>
                            <div class="flex justify-between gap-4">
                                <div>
                                    <span class="text-pink-500">ID Koordinator : </span>
                                    <span class="text-blue-500">{{ $data->id }}</span>
                                </div>
                                <span class="text-green-500">{{ $data->user->no_telpon }}</span>
                            </div>
                            <span class="text-gray-500">{{ $data->areaAlamat->nama }}</span>
                        </div>

                        <div class="flex justify-center items-center gap-4">
                            <a href="{{ route('kasir.edit', ['kasir' => $data->id ]) }}">
                                <img src="{{ asset('images/edit.png') }}" alt="Edit" class="pb-2  w-8">
                            </a>
                            <form action="{{ route('kasir.destroy', ['kasir' => $data->id]) }}" method="post">
                                @csrf
                                @method('delete')

                                <button type="submit">
                                    <img src="{{ asset('images/hapus.png') }}" alt="Hapus" class="w-8">
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </main>
</x-layout.dashboard>
