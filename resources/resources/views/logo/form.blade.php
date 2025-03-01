<x-layout.dashboard>
    <div class="flex flex-col gap-4 justify-center items-center w-full">
        <img src="{{ asset('images/tambah-gambar.png') }}" alt="Tambah gambar">
        <h2 class="text-2xl">UBAH LOGO</h2>
        <form action="{{ route('logo.store') }}" enctype="multipart/form-data" method="post"
            class="flex flex-col gap-4 justify-center items-center md:w-[50%] sm:w-[90%] mx-4">
            @csrf
            <div class="flex flex-col gap-1 w-full">
                <label for="logo" class="flex flex-col justify-between cursor-pointer w-full">
                    <input data-custom-file-upload="#custom-file-show" id="logo" type="file" name="logo"
                        class="opacity-0 absolute pointer-events-none" {{ isset($pelanggan) ? "" : "required" }}>
                    <span>Logo : </span>
                    <div class="flex flex-row justify-between w-full border-black border-2 p-2">
                        <div class="flex flex-col gap-1">
                            <span class="text-gray-400" id="custom-file-show">LOGO_PERUSAHAAN.PNG</span>
                        </div>
                        <div class="flex items-end">
                            <img src="{{ asset('images/buka-folder.png') }}" alt="Upload" class="w-8">
                        </div>
                    </div>
                </label>
            </div>

            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="flex flex-col gap-2">
                    @foreach ($errors->all() as $error)
                    <li class="text-white bg-red-600 p-2 rounded">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <button type="submit" class="py-1 px-4 bg-green-500 text-white text-2xl rounded">SIMPAN PERUBAHAN</button>
        </form>
    </div>
</x-layout.dashboard>
