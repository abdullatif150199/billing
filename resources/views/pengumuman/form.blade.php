<x-layout.dashboard>
    <div class="flex flex-col justify-center items-center gap-8 p-8 w-full">
        @if(session()->has('message') && session()->get('message')['status'] == "success")
        <div class="flex flex-col gap-2 p-2 m-2 w-full">
            <span class="bg-green-500 text-white p-2 rounded">{{ session()->get('message')['message'] }}</span>
        </div>
        @endif

        <form method="post" action="{{ route('pengumuman.store') }}" class="flex flex-col justify-center items-start w-full gap-1">
            @csrf
            <label for="pengumuman" class="text-xl text-left">Pesan Pengumuman : </label>
            <textarea name="pengumuman" id="pengumuman" cols="30" rows="10" class="border-4 border-black w-full p-1">{{ $pengumuman->data == "" ? "tidak ada pengumuman" : $pengumuman->data}}</textarea>
            <button type="submit" class="m-auto py-1 px-4 bg-blue-500 font-bold text-lg">Kirim</button>
        </form>

        <p class="text-xl text-center">
            Kirim pesan teks pengumuman yang akan otomatis ditampilkan pada
            halaman depan kolom pengumuman di web kasir dan pelanggan
        </p>
    </div>
</x-layout.dashboard>
