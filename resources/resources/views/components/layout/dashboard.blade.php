<x-layout.default-layout>
    <div class="relative flex flex-col min-w-screen min-h-screen">
        <header class="flex justify-between w-full bg-stratos-950 p-2">
            <button data-reveal-target="#dashboard-menu" class="flex items-center justify-center">
                <img src="{{ asset('images/main-menu.png') }}" alt="Main menu" class="w-8">
            </button>
            <div>
                <img src="{{ asset(Storage::url(App\Models\DataMaster::where('nama', 'logo')->first()->data)) }}" alt="Logo" class="flex justify-center items-center w-44 h-12 text-center bg-white object-cover">
            </div>
            <div class="flex items-center justify-center gap-2">
                <img src="{{ isset(auth()->user()->foto) ? asset(Storage::url(auth()->user()->foto)) : asset('images/foto-profil-default.png') }}" alt="Foto profil" class="flex justify-center items-center w-8 h-8 rounded-full bg-white object-cover">
                @role('admin')
                <span class="text-white"> Hai, {{ auth()->user()->name}} </span>
                @endrole

                @role('pelanggan')
                <span class="text-white"> Hai, {{ auth()->user()->pelanggan->nama}} </span>
                @endrole

                @role('koordinator')
                <span class="text-white"> Hai, {{ auth()->user()->kasir->nama}} </span>
                @endrole
            </div>
        </header>

        <div class="flex self-stretch items-start flex-1">
            <div id="dashboard-menu" data-reveal-state="1" class="relative flex flex-1 max-w-[18rem] self-stretch flex-col justify-stretch bg-red-400">
                <h1 class="bg-red-600 text-white text-lg text-center">MAIN NAVIGATOR</h1>
                <div class="absolute right-[0] top-[50%] z-10">
                    <button data-reveal-target="#dashboard-menu">
                        <svg class="h-12 w-12 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6" />
                        </svg>
                    </button>
                </div>
                <nav class="flex flex-col gap-2">
                    <ul class="flex flex-col gap-2">
                        <li>
                            <x-shared.navlink name="Dashboard" route="dashboard" :icon="asset('images/dashboard.png')" :border="false" />
                        </li>

                        @role('admin')
                        <li>
                            <x-shared.navlink name="Data Pelanggan" route="pelanggan.index" :icon="asset('images/data-pelanggan.png')" :border="false" />
                        </li>

                        <li>
                            <x-shared.navlink name="Keuangan" route="keuangan.index" :icon="asset('images/keuangan.png')" :border="false" />
                        </li>

                        <li>
                            <x-shared.navlink name="Pembayaran" route="tagihan.index" :icon="asset('images/pembayaran.png')" :border="false" />
                        </li>

                        <li>
                            <div class="relative flex flex-col gap-3">
                                @php
                                $dropdownState = Route::currentRouteName() == 'paket-langanan.index' || Route::currentRouteName() == 'alamat.index'
                                || Route::currentRouteName() == 'profile.show' || Route::currentRouteName() == 'logo.create';
                                @endphp
                                <button data-dropdown-state="{{ $dropdownState ? '1' : '0' }}" data-dropdown-target="#dropdown-pengaturan" class="flex justify-between items-center gap-2 p-2">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ asset('images/pengaturan.png') }}" alt="Pengaturan" class="w-8 rounded">
                                        <span>Pengaturan</span>
                                    </div>
                                    <svg data-dropdown-icon class="h-8 w-8 text-black duration-300" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <polyline points="6 9 12 15 18 9" />
                                    </svg>
                                </button>

                                <ul id="dropdown-pengaturan" class="flex flex-col gap-2 px-2">
                                    <x-shared.navlink name="Akun Mikrotik" route="mikrotik.index" :icon="asset('images/akun-mikrotik.png')" :border="true" />
                                    <x-shared.navlink name="Area / Alamat" route="alamat.index" :icon="asset('images/area-alamat.png')" :border="true" />
                                    <x-shared.navlink name="Paket Pelanggan" route="paket-langanan.index" :icon="asset('images/paket-langganan.png')" :border="true" />
                                    <x-shared.navlink name="Akun" route="profile.show" :icon="asset('images/username.png')" :border="true" />
                                    <x-shared.navlink name="Kasir / Koordinator" route="kasir.index" :icon="asset('images/kasir-koordinator.png')" :border="true" />
                                    <x-shared.navlink name="Logo" route="logo.create" :icon="asset('images/tambah-gambar.png')" :border="true" />
                                </ul>
                            </div>
                        </li>

                        <li>
                            <x-shared.navlink name="Verifikasi Pembayaran" route="verifikasi-pembayaran.index" :icon="asset('images/verifikasi-pembayaran.png')" :border="false" />
                        </li>

                        <li>
                            <x-shared.navlink name="Status Koneksi Server" route="status-koneksi.index" :icon="asset('images/status-koneksi-server.png')" :border="false" />
                        </li>

                        <li>
                            <x-shared.navlink name="Pengumuman" route="pengumuman.create" :icon="asset('images/pemberitahuan.png')" :border="false" />
                        </li>
                        @endrole

                        @role('pelanggan')
                        <li>
                            <x-shared.navlink name="Riwayat Pembayaran" route="riwayat-pembayaran" :icon="asset('images/riwayat-pembayaran.png')" :border="false" />
                        </li>

                        <li>
                            <x-shared.navlink name="Customer Service" route="customer-service-pelanggan.index" :icon="asset('images/logo-whatsapp.png')" :border="false" />
                        </li>

                        <li>
                            <a href="http://192.168.1.1" class="flex items-center gap-2 px-2 py-1 hover:bg-red-300">
                                <img src="{{ asset('images/modem.png') }}" alt="Modem" class="w-8 rounded">
                                <span>Modem</span>
                            </a>
                        </li>

                        <li>
                            <a href="http://10.10.10.20/speedtest" class="flex items-center gap-2 px-2 py-1 hover:bg-red-300">
                                <img src="{{ asset('images/speedtest.png') }}" alt="Modem" class="w-8 rounded">
                                <span>Speedtest</span>
                            </a>
                        </li>

                        <div class="relative flex flex-col gap-3">
                            @php
                            $dropdownState = Route::currentRouteName() == 'profile.show';
                            @endphp
                            <button data-dropdown-state="{{ $dropdownState ? '1' : '0' }}" data-dropdown-target="#dropdown-pengaturan" class="flex justify-between items-center gap-2 p-2">
                                <div class="flex items-center gap-2">
                                    <img src="{{ asset('images/pengaturan.png') }}" alt="Pengaturan" class="w-8 rounded">
                                    <span>Pengaturan</span>
                                </div>
                                <svg data-dropdown-icon class="h-8 w-8 text-black duration-300" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </button>

                            <ul id="dropdown-pengaturan" class="flex flex-col gap-2 px-2">
                                <x-shared.navlink name="Profile" route="profile.show" :icon="asset('images/username.png')" :border="true" />
                            </ul>
                        </div>
                        @endrole

                        @role('koordinator')
                        <li>
                            <x-shared.navlink name="Ajukan Pembayaran" route="pengajuan.index" :icon="asset('images/scan-barcode.png')" :border="false" />
                        </li>

                        <li>
                            <x-shared.navlink name="Customer Service" route="customer-service-koordinator.index" :icon="asset('images/logo-whatsapp.png')" :border="false" />
                        </li>

                        <div class="relative flex flex-col gap-3">
                            @php
                            $dropdownState = Route::currentRouteName() == 'profile.show';
                            @endphp
                            <button data-dropdown-state="{{ $dropdownState ? '1' : '0' }}" data-dropdown-target="#dropdown-pengaturan" class="flex justify-between items-center gap-2 p-2">
                                <div class="flex items-center gap-2">
                                    <img src="{{ asset('images/pengaturan.png') }}" alt="Pengaturan" class="w-8 rounded">
                                    <span>Pengaturan</span>
                                </div>
                                <svg data-dropdown-icon class="h-8 w-8 text-black duration-300" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" />
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </button>

                            <ul id="dropdown-pengaturan" class="flex flex-col gap-2 px-2">
                                <x-shared.navlink name="Profile" route="profile.show" :icon="asset('images/username.png')" :border="true" />
                            </ul>
                        </div>
                        @endrole
                    </ul>
                </nav>
            </div>

            <main class="flex flex-1 self-stretch w-full bg-orange-100">
                {{ $slot }}
            </main>
        </div>
    </div>
</x-layout.default-layout>
