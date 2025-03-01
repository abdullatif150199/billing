<x-layout.dashboard>

    <div id="main-container" class="relative flex flex-col gap-4 w-full p-4">
        <h1 class="text-2xl text-center">Data pelanggan</h1>
        <div>
            <a href="{{ route('pelanggan.create') }}" class="bg-blue-500 rounded px-4 py-2 font-extrabold text-lg text-white">Tambah</a>
        </div>
        <div>
            <form data-custom-form-get action="{{ route('pelanggan.index') }}" method="get" class="w-full flex gap-4 justify-between">
                <div class="flex justify-center items-center gap-4 w-full">
                    <button type="submit">
                        <img src="{{ asset('images/cari-hitam.png') }}" alt="pencarian" class="h-6">
                    </button>
                    <input data-custom-form type="text" name="nama" placeholder="Cari Pelanggan" class="border-b-2 border-black p-2 w-full bg-transparent" value="{{ $nama }}">
                </div>

                <div class="flex justify-center items-center gap-2 w-full">
                    <select data-custom-form name="alamat" id="alamat" class="p-2 w-full bg-transparent border-b-2 border-black text-right">
                        @if($alamatId == null)
                        <option value="" hidden selected disabled>Filter Alamat</option>
                        @else
                        <option value="">Filter Alamat</option>
                        @endif
                        @foreach($alamat as $data)
                        @if($data->id == $alamatId)
                        <option value="{{ $data->id }}" selected>{{ $data->nama }}</option>
                        @else
                        <option value="{{ $data->id }}">{{ $data->nama }}</option>
                        @endif
                        @endforeach
                    </select>
                    <button type="submit">
                        <img src="{{ asset('images/filter.png') }}" alt="pencarian" class="h-6">
                    </button>
                </div>
            </form>
        </div>
        <main>
            <ul class="flex flex-col gap-4">
                @foreach($pelanggan as $data)
                <li class="flex flex-col gap-2 bg-white p-2">
                    <div class="flex justify-between items-center gap-2">
                        <div class="flex flex-col">
                            <h4>{{ $data->nama }}</h4>

                            <span>
                                <span class="text-pink-600">No Pelanggan: </span>
                                <span class="text-blue-600">{{ $data->id }}</span>
                            </span>

                            <span>
                                <span class="text-yellow-600">Paket Langganan: </span>
                                <span class="text-blue-600">{{ $data->paketLangganan->nama }}</span>
                            </span>

                            <span class="text-gray-600">{{ $data->areaAlamat->nama }}</span>
                        </div>

                        <div class="flex flex-row items-center justify-center gap-4">

                            <a href="{{ route('pelanggan.show', ['pelanggan' => $data->id]) }}">
                                <img src="{{ asset('images/lihat-detail.png') }}" alt="Liat detail" class="w-8">
                            </a>

                            <a href="{{ route('pelanggan.edit', ['pelanggan' => $data->id]) }}">
                                <img src="{{ asset('images/edit.png') }}" alt="Edit Pelanggan" class="w-8 mb-1">
                            </a>

                            <button onclick="popoutKonfirmasiHapus(`{{ $data->nama }}`, `{{ $data->id }}`, `{{ $data->areaAlamat->nama }}`, `{{ route('pelanggan.destroy', ['pelanggan' => $data->id]) }}`, `{{ csrf_token() }}`)">
                                <img src="{{ asset('images/hapus.png') }}" alt="Hapus" class="w-8">
                            </button>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </main>
    </div>

</x-layout.dashboard>
