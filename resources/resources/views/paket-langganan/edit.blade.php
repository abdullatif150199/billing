<x-layout.dashboard>
    <div class="flex-col gap-4 w-full">
        <section class="flex flex-col gap-2 w-full p-4">
            <header class="flex flex-col justify-center items-center">
                <img src="{{ asset('images/paket-langganan.png') }}" alt="Paket" class="w-24">
                <h1 class="text-3xl">PAKET LANGGANAN</h1>
            </header>

            <form action="{{ route('paket-langanan.update', ['paket_langanan' => $data->id]) }}" method="post" class="flex flex-col gap-1">
                @csrf
                @method('patch')
                <h2 class="text-2xl text-pink-600">EDIT PAKET</h2>

                <div class="flex flex-col">
                    <label for="nama-paket" class="text-lg">Nama Paket : </label>
                    <input type="text" id="nama-paket" name="nama" placeholder="Nama Paket" value="{{ $data->nama }}" class="border-b-2 border-black p-2" required>
                </div>

                <div class="flex flex-col">
                    <label for="harga-paket" class="text-lg">Harga Paket : </label>
                    <input type="number" id="harga-paket" name="harga" placeholder="Harga Paket" value="{{ $data->harga }}" class="border-b-2 border-black p-2" required>
                </div>

                <div class="flex justify-center items-center">
                    <button type="submit" class="text-white bg-green-600 py-1 px-4 rounded">SIMPAN</button>
                </div>
            </form>
        </section>
    </div>
</x-layout.dashboard>
