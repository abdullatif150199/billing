<x-layout.dashboard>
    <div class="flex-col gap-4 w-full">
        <section class="flex flex-col gap-2 w-full p-4">
            <header class="flex flex-col justify-center items-center">
                <img src="{{ asset('images/area-alamat.png') }}" alt="Paket" class="w-24">
                <h1 class="text-3xl">Area Alamat</h1>
            </header>

            <form action="{{ route('alamat.store') }}" method="post" class="flex flex-col gap-1">
                @csrf
                <h2 class="text-2xl text-pink-600">TAMBAHKAN AREA / ALAMAT</h2>

                <div class="flex flex-col">
                    <label for="nama-area-alamat" class="text-lg">Nama Alamat / Area : </label>
                    <div class="flex flex-row gap-4 border-b-2 border-black p-2">
                        <input type="text" id="nama-area-alamat" name="nama" placeholder="Nama Alamat / Area Lengkap" class="w-full" required>
                        <div class="flex justify-center items-center">
                            <button type="submit">
                                <img src="{{ asset('images/tambah.png') }}" alt="Tambah" class="w-6">
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </section>

        <section class="flex flex-col gap-1 w-full p-4">
            <h2 class="text-pink-600 text-2xl">DAFTAR AREA / ALAMAT</h2>
            <ul>
                @foreach($areaAlamat as $data)
                <li class="flex justify-between items-center border-b-2 border-black p-2">
                    <div>
                        <span>{{ $data->nama }}</span>
                    </div>
                    <div class="flex justify-center items-center gap-4">
                        <a href="{{ route('alamat.edit', ['alamat' => $data->id]) }}">
                            <img src="{{ asset('images/edit.png') }}" alt="Edit" class="w-6">
                        </a>

                        <form action="{{ route('alamat.destroy', ['alamat' => $data->id]) }}" method="post">
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
