<x-layout.dashboard>
    <div class="flex-col gap-4 w-full">
        <section class="flex flex-col gap-2 w-full p-4">
            <header class="flex flex-col justify-center items-center">
                <img src="{{ asset('images/paket-langganan.png') }}" alt="Paket" class="w-24">
                <h1 class="text-3xl">Paket Langganan</h1>
            </header>

            <form action="{{ route('paket-langanan.store') }}" method="post" class="flex flex-col gap-1">
                @csrf
                <h2 class="text-2xl text-pink-600">TAMBAHKAN PAKET</h2>

                <div class="flex flex-col">
                    <label for="nama-paket" class="text-lg">Nama Paket : </label>
                    <input type="text" id="nama-paket" name="nama" placeholder="Nama Paket" class="border-b-2 border-black p-2" required>
                </div>

                <div class="flex flex-col">
                    <label for="harga-paket" class="text-lg">Harga Paket : </label>
                    <input type="text" id="harga-paket" name="harga" placeholder="Harga Paket" class="border-b-2 border-black p-2" required>
                </div>

                <div class="flex justify-center items-center">
                    <button type="submit" class="text-white bg-green-600 py-1 px-4 rounded">SIMPAN</button>
                </div>
            </form>
        </section>

        <section class="flex flex-col gap-1 w-full p-4">
            <h2 class="text-pink-600 text-2xl">DAFTAR PAKET</h2>
            <ul>
                @foreach($paketLangganan as $data)
                <li class="flex justify-between items-center border-b-2 border-black p-2">
                    <div>
                        <span>{{ $data->nama }}</span>
                    </div>
                    <div class="flex justify-center items-center gap-4">
                        <span>Rp {{ number_format($data->harga, 0, ',', '.') }},00</span>
                        <a href="{{ route('paket-langanan.edit', ['paket_langanan' => $data->id]) }}">
                            <img src="{{ asset('images/edit.png') }}" alt="Edit" class="w-6">
                        </a>

                        <form action="{{ route('paket-langanan.destroy', ['paket_langanan' => $data->id]) }}" method="post">
                            @csrf
                            @method('delete')

                            <button type="submit">
                                <img src="{{ asset('images/hapus.png') }}" alt="Hapus" class="w-6">
                            </button>
                        </form>
                    </div>
                </li>
                @endforeach
            </ul>
        </section>
    </div>
</x-layout.dashboard>
