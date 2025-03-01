<x-layout.dashboard>
    <!--TODO : Refactor this-->
    <div data-preview="#foto-rumah" class="fixed top-0 left-0 flex justify-center items-center z-20 w-screen h-screen bg-black bg-opacity-50 hidden">
        <div class="absolute top-0 sm:right-2 lg:right-8">
            <button data-close>
                <svg class="h-8 w-8 text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
        <div>
            <img src="{{ asset(Storage::url($pelanggan->foto_rumah)) }}" alt="Foto Rumah" class="h-[92vh] object-fill">
        </div>
    </div>

    <!--TODO : Refactor this-->
    <div data-preview="#foto-ktp" class="fixed top-0 left-0 flex justify-center items-center z-20 w-screen h-screen bg-black bg-opacity-50 hidden">
        <div class="absolute top-0 sm:right-2 lg:right-8">
            <button data-close>
                <svg class="h-8 w-8 text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
        <div>
            <img src="{{ asset(Storage::url($pelanggan->user->foto)) }}" alt="Foto Rumah" class="h-[92vh] object-fill">
        </div>
    </div>

    <div class="flex flex-col w-full">

        <header class="relative flex items-end h-[54vh]">
            <img id="foto-rumah" src="{{ asset(Storage::url($pelanggan->foto_rumah)) }}" alt="Foto rumah" class="absolute w-full h-full object-cover brightness-90">
            <div class="flex justify-center items-center gap-4 z-10 p-4">
                <div class="flex flex-col justify-center items-center">
                    <img id="foto-ktp" src="{{ asset(Storage::url($pelanggan->user->foto)) }}" alt="foto ktp" class="rounded-full w-24 h-24 object-cover">
                </div>
                <div class="flex flex-col">
                    <h1 class="text-red-600 text-shadow-sm shadow-black text-2xl">{{ $pelanggan->nama }}</h1>
                    <h2 class="text-white text-shadow-sm shadow-black text-xl">ID : <span class="text-blue-600">{{ $pelanggan->id }}</span></h2>
                    <h3 class="text-green-600 text-shadow-sm shadow-black text-lg">{{ $pelanggan->user->no_telpon }}</h3>
                </div>
            </div>
        </header>

        <main class="flex flex-col gap-3 divide-y-2 divide-black border-black border-t-2 border-b-2 p-4">
            <div>
                <h4 class="text-xl">Tanggal Register : </h4>
                <span class="text-green-600">{{ $pelanggan->tanggal_register->translatedFormat('j F o') }}</span>
            </div>

            <div>
                <h4 class="text-xl">Tanggal Tagihan : </h4>
                <span class="text-green-600">{{ str_pad($pelanggan->tanggal_tagihan, 2, "0", STR_PAD_LEFT) }}</span>
            </div>

            <div>
                <h4 class="text-xl">Tanggal Jatuh Tempo : </h4>
                <span class="text-green-600">{{ str_pad($pelanggan->tanggal_jatuh_tempo, 2, "0", STR_PAD_LEFT) }}</span>
            </div>

            <div>
                <h4 class="text-xl">Paket Langganan : </h4>
                <span class="text-green-600">{{ $pelanggan->paketLangganan->nama }}</span>
            </div>

            <div>
                <h4 class="text-xl">Alamat : </h4>
                <span class="text-green-600">{{ $pelanggan->areaAlamat->nama }}</span>
            </div>

            <div class="flex justify-between items-center">
                <div class="flex flex-col">
                    <h4 class="text-xl">Titik Koordinat Maps Rumah Pelanggan :</h4>
                    <span class="text-green-600">{{ $pelanggan->google_map }}</span>
                </div>
                <div>
                    <a href="http://maps.google.co.uk/maps?q={{ str_replace(' ', '' , $pelanggan->google_map) }}" target="_blank">
                        <img src="{{ asset('images/area-alamat.png')}}" alt="Map" class="w-8 h-8 mx-4">
                    </a>
                </div>
            </div>

            <div class="flex justify-between items-center">
                <div class="flex flex-col">
                    <h4 class="text-xl">IP Address : </h4>
                    <span id="ip-address" class="text-green-600">{{ $pelanggan->ip_address }}</span>
                </div>
                <div class="relative">
                    <span class="absolute -top-4 left-0 bg-gray-200 rounded py-1 px-2 opacity-0 duration-300 pointer-events-none" data-tooltip>Copied</span>
                    <img src="{{ asset('images/salin.png') }}" alt="salin" class="w-8 h-8 mx-4 cursor-pointer" data-copy-from="#ip-address">
                </div>
            </div>

            <div class="flex justify-between items-center">
                <div class="flex flex-col">
                    <h4 class="text-xl">Serial Number Modem : </h4>
                    <span id="serial-number-modem" class="text-green-600">{{ $pelanggan->serial_number_modem }}</span>
                </div>
                <div class="relative">
                    <span class="absolute -top-4 left-0 bg-gray-200 rounded py-1 px-2 opacity-0 duration-300 pointer-events-none" data-tooltip>Copied</span>
                    <img src="{{ asset('images/salin.png') }}" alt="salin" class="w-8 h-8 mx-4 cursor-pointer" data-copy-from="#serial-number-modem">
                </div>
            </div>

            <div>
                <h4 class="text-xl">Username : </h4>
                <span class="text-green-600">{{ $pelanggan->user->name }}</span>
            </div>

            <div>
                <h4 class="text-xl">Password : </h4>
                <span class="text-green-600">{{ $pelanggan->user->password_not_hashed }}</span>
            </div>
        </main>
    </div>

</x-layout.dashboard>
