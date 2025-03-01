<x-layout.dashboard>
    <div class="flex-col gap-4 w-full">
        <section class="flex flex-col gap-2 w-full p-4">
            <header>
                <h1 class="text-2xl text-center">{{ isset($pelanggan) ? "EDIT PELANGGAN" : "TAMBAH PELANGGAN" }}</h1>
                <h2 class="text-lg text-red-600 text-center">Isi data pelanggan dibawah ini dengan lengkap dan jelas!</h2>
            </header>

            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="flex flex-col gap-2">
                    @foreach ($errors->all() as $error)
                    <li class="text-white bg-red-600 p-2 rounded">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif


            <form action="{{ isset($pelanggan) ? route('pelanggan.update', ['pelanggan' => $pelanggan->id]) : route('pelanggan.store') }}" method="post" class="flex flex-col gap-2" enctype="multipart/form-data">
                @csrf
                @if(isset($pelanggan))
                @method('patch')
                @endif
                <div class="flex flex-col gap-1">
                    <label for="nama">Nama : </label>
                    <input type="text" name="nama" id="nama" placeholder="contoh: Gito Kobong" class="border-b-[1px] border-black p-2" value="{{ isset($pelanggan) ? $pelanggan->nama : old('nama') }}" required>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="id_pelanggan">ID Pelanggan : </label>
                    <input data-auto-fill-target="#username,#password" type="text" name="id" id="id-pelanggan" placeholder="contoh: 001010" class="border-b-[1px] border-black p-2" value="{{ isset($pelanggan) ? $pelanggan->id : old('idPelanggan') }}" required>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="nomer-telepon">Nomor Telepon / Whatsapp : </label>
                    <input type="text" name="nomerTelpon" id="nomor-telepon" placeholder="contoh: 085890004522" class="border-b-[1px] border-black p-2" value="{{ isset($pelanggan) ? $pelanggan->user->no_telpon : old('nomerTelpon') }}" required>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="tanggal-register">Tanggal Register : </label>
                    <input type="date" name="tanggalRegister" id="tanggal-register" class="border-b-[1px] border-black p-2" value="{{ isset($pelanggan) ? $pelanggan->tanggal_register->toDateString() : old('tanggalRegister') }}" required>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="tanggal-tagihan">Tanggal Tagihan : </label>
                    <input type="number" name="tanggalTagihan" id="tanggal-tagihan" class="border-b-[1px] border-black p-2" value="{{ isset($pelanggan) ? $pelanggan->tanggal_tagihan : old('tanggalTagihan') }}" required>
                </div>


                <div class="flex flex-col gap-1">
                    <label for="tanggal-jatuh-tempo">Tanggal Jatuh Tempo : </label>
                    <input type="number" name="tanggalJatuhTempo" id="tanggal-jatuh-tempo" class="border-b-[1px] border-black p-2" value="{{ isset($pelanggan) ? $pelanggan->tanggal_jatuh_tempo : old('tanggalJatuhTempo') }}" required>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="paket-langganan">Paket Langganan : </label>
                    <select name="paketLangganan" id="paket-langganan" class="bg-white p-2 border-b-[1px] border-black" required>
                        @isset($pelanggan)
                        <option value="{{ $pelanggan->paketLangganan->id }}" selected>{{ $pelanggan->paketLangganan->nama }} - Rp {{ number_format($pelanggan->paketLangganan->harga, 0) }},00</option>
                        @endisset

                        @foreach($paket as $data)

                        @if(isset($pelanggan))

                        @if($pelanggan->paketLangganan->id != $data->id)
                        <option value="{{ $data->id }}">{{ $data->nama }} - Rp {{ number_format($data->harga, 0) }},00</option>
                        @endif

                        @else
                        <option value="{{ $data->id }}">{{ $data->nama }} - Rp {{ number_format($data->harga, 0) }},00</option>
                        @endif

                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="alamat">Alamat : </label>
                    <select name="areaAlamat" id="alamat" class="bg-white p-2 border-b-[1px] border-black" required>
                        @isset($pelanggan)
                        <option value="{{ $pelanggan->areaAlamat->id }}">{{ $pelanggan->areaAlamat->nama }}</option>
                        @endisset
                        @foreach($areaAlamat as $data)
                        @if(isset($pelanggan))

                        @if($pelanggan->areaAlamat->id != $data->id)
                        <option value="{{ $data->id }}">{{ $data->nama }}</option>
                        @endif

                        @else
                        <option value="{{ $data->id }}">{{ $data->nama }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="google-map">Titik Koordinat Maps Rumah Pelanggan : </label>
                    <input type="text" name="googleMap" id="google-map" placeholder="contoh: -7.790237, 110.370568" class="border-b-[1px] border-black p-2" value="{{ isset($pelanggan) ? $pelanggan->google_map : old('googleMap') }}" required>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="ip-address">IP Address : </label>
                    <input type="text" name="ipAddress" id="ip-address" placeholder="contoh: 10.0.1.222" class="border-b-[1px] border-black p-2" value="{{ isset($pelanggan) ? $pelanggan->ip_address : old('ipAddress') }}" required>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="serial-number-modem">Serial Number Modem : </label>
                    <input type="text" name="serialNumberModem" id="serial-number-modem" placeholder="contoh: ZTEGC0345678" class="border-b-[1px] border-black p-2" value="{{ isset($pelanggan) ? $pelanggan->serial_number_modem : old('serialNumberModem') }}" required>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="foto-rumah" class="flex justify-between border-b-[1px] border-black p-2 cursor-pointer">
                        <input data-custom-file-upload="#custom-file-show" id="foto-rumah" type="file" name="fotoRumah" class="opacity-0 absolute pointer-events-none" {{ isset($pelanggan) ? "" : "required" }}>
                        <div class="flex flex-col gap-1">
                            <span>Foto Rumah : </span>
                            <span class="text-gray-400" id="custom-file-show">{{ isset($pelanggan) ? "Memakai yang lama jika kosong" : "contoh DSC00765346.JPG" }}</span>
                        </div>
                        <div class="flex items-end">
                            <img src="{{ asset('images/buka-folder.png') }}" alt="Upload" class="w-8">
                        </div>
                    </label>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="foto-ktp" class="flex justify-between border-b-[1px] border-black p-2 cursor-pointer">
                        <input data-custom-file-upload="#custom-file-show" id="foto-ktp" type="file" name="fotoKtp" class="opacity-0 absolute pointer-events-none" {{ isset($pelanggan) ? "" : "required" }}>
                        <div class="flex flex-col gap-1">
                            <span>Foto KTP : </span>
                            <span class="text-gray-400" id="custom-file-show">{{ isset($pelanggan) ? "Memakai yang lama jika kosong" : "contoh DSC00765346.JPG" }}</span>
                        </div>
                        <div class="flex items-end">
                            <img src="{{ asset('images/buka-folder.png') }}" alt="Upload" class="w-8">
                        </div>
                    </label>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="username">Username : </label>
                    <input type="text" name="name" id="username" placeholder="contoh: 001010" class="border-b-[1px] border-black p-2" value="{{ isset($pelanggan) ? $pelanggan->id : old('name') }}" required>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="password">Password : </label>
                    <input type="password" name="password" id="password" placeholder="contoh: 001010" class="border-b-[1px] border-black p-2" value="{{ isset($pelanggan) ? $pelanggan->user->password_not_hashed : old('password') }}" required>
                </div>

                <button type="submit" class="bg-green-600 rounded py-1 text-2xl font-bold">SIMPAN</button>
            </form>
        </section>
    </div>
</x-layout.dashboard>
