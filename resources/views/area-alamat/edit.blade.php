<x-layout.dashboard>
    <div class="flex-col gap-4 w-full">
        <section class="flex flex-col gap-2 w-full p-4">
            <header class="flex flex-col justify-center items-center">
                <img src="{{ asset('images/area-alamat.png') }}" alt="Paket" class="w-24">
                <h1 class="text-3xl">Area Alamat</h1>
            </header>

            <form action="{{ route('alamat.update', ['alamat' => $data->id]) }}" method="post" class="flex flex-col gap-1">
                @csrf
                @method('patch')
                <h2 class="text-2xl text-pink-600">EDIT AREA / ALAMAT</h2>

                <div class="flex flex-col">
                    <label for="nama-area-alamat" class="text-lg">Nama Alamat / Area : </label>
                    <input type="text" id="nama-area-alamat" name="nama" value="{{ $data->nama }}" placeholder="Nama Alamat / Area Lengkap" class="w-full border-b-2 border-black p-2" required>
                </div>

                <div class="flex justify-center items-center">
                    <button type="submit" class="text-white bg-green-600 py-1 px-4 rounded">SIMPAN</button>
                </div>
            </form>
        </section>
    </div>
</x-layout.dashboard>
