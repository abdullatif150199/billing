<x-layout.dashboard>
    <main class="p-8 w-full">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="flex flex-col gap-2">
                @foreach ($errors->all() as $error)
                <li class="text-white bg-red-600 p-2 rounded">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ isset($kasir) ? route('kasir.update', ['kasir' => $kasir->id]) : route('kasir.store') }}" method="post" class="flex flex-col gap-2" enctype="multipart/form-data">
            @csrf
            @if(isset($kasir))
            @method('patch')
            @endif
            <div class="flex flex-col gap-1">
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama" placeholder="Nama" class="border-b-[1px] border-black p-2 bg-transparent" value="{{ isset($kasir) ? $kasir->nama : old('nama') }}" required>
            </div>

            <div class="flex flex-col gap-1">
                <label for="id">ID : </label>
                <input data-auto-fill-target="#name,#password" type="text" name="id" id="id" placeholder="ID" class="border-b-[1px] border-black p-2 bg-transparent" value="{{ isset($kasir) ? $kasir->id : old('id') }}" required>
            </div>

            <div class="flex flex-col gap-1">
                <label for="alamat">Alamat : </label>
                <select name="areaAlamat" id="alamat" class="bg-white p-2 border-b-[1px] border-black" required>
                    @isset($kasir)
                    <option value="{{ $kasir->areaAlamat->id }}">{{ $kasir->areaAlamat->nama }}</option>
                    @endisset
                    @foreach($areaAlamat as $data)
                    @if(isset($kasir))

                    @if($kasir->areaAlamat->id != $data->id)
                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                    @endif

                    @else
                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                    @endif
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col gap-1">
                <label for="nomer-telepon">Nomor Telepon / Whatsapp : </label>
                <input type="text" name="noTelpon" id="nomor-telepon" placeholder="Whatsapp" class="border-b-[1px] border-black p-2 bg-transparent" value="{{ isset($kasir) ? $kasir->user->no_telpon : old('noTelpon') }}" required>
            </div>

            <div class="flex flex-col gap-1">
                <label for="foto" class="flex justify-between border-b-[1px] border-black p-2 cursor-pointer">
                    <input data-custom-file-upload="#custom-file-show" id="foto" type="file" name="foto" class="opacity-0 absolute pointer-events-none" {{ isset($kasir) ? "" : "required" }}>
                    <div class="flex flex-col gap-1">
                        <span>Foto : </span>
                        <span class="text-gray-400" id="custom-file-show">{{ isset($pelanggan) ? "Memakai yang lama jika kosong" : "Foto" }}</span>
                    </div>
                    <div class="flex items-end">
                        <img src="{{ asset('images/buka-folder.png') }}" alt="Upload" class="w-8">
                    </div>
                </label>
            </div>

            <div class="flex flex-col gap-1">
                <label for="name">Username : </label>
                <input type="text" name="name" id="name" placeholder="Username" class="border-b-[1px] border-black p-2 bg-transparent" value="{{ isset($kasir) ? $kasir->user->name : old('name') }}" required>
            </div>

            <div class="flex flex-col gap-1">
                <label for="password">Password : </label>
                <input type="password" name="password" id="password" placeholder="Password" class="border-b-[1px] border-black p-2 bg-transparent" value="{{ isset($kasir) ? $kasir->user->password_not_hashed : old('password') }}" required>
            </div>

            <div class="self-center">
                <button type="submit" class="bg-blue-500 py-1 px-2 font-bold text-2xl">SIMPAN</button>
            </div>
        </form>
    </main>
</x-layout.dashboard>
