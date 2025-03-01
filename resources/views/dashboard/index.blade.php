<x-layout.dashboard>

    @role('admin')
    <div class="flex flex-col justify-center items-center gap-8 w-full p-4">
        <header class="flex justify-center items-center gap-4">
            <img src="{{ asset('images/kalender.png') }}" alt="Kalender" class="w-12">
            <span class="text-2xl">{{ now()->translatedFormat('l, j F o') }}</span>
        </header>

        <main class="flex flex-col justify-center items-center w-full">
            <h1 class="text-2xl">Selamat datang di Billing!</h1>
            <img src="{{ asset(Storage::url(auth()->user()->foto)) }}" alt="Foto Profil" class="flex justify-center items-center w-64 h-64 rounded object-cover bg-gray-200">
            <span class="text-center text-lg font-bold"> {{ auth()->user()->name }} </span>
        </main>

    </div>
    @endrole

    @role('pelanggan')
    <div class="flex flex-col gap-4 w-full">
        <div class="flex flex-col gap-4 bg-white p-2 m-2 text-center">
            <h2 class="font-bold text-xl">INFORMASI PAKET LANGGANAN</h2>
            <h1 class="text-2xl text-green-500">{{ auth()->user()->pelanggan->paketLangganan->nama }}</h1>
            <h3 class="text-lg text-orange-500">Sekarang anda sedang belangganan pada paket internet ini</h3>
        </div>

        <div class="flex flex-col gap-4 bg-white p-2 m-2 text-center">
            <h2 class="font-bold text-xl">TAGIHAN INTERNET</h2>
            @if($currentPaket->status_tagihan == App\Enums\StatusTagihan::LUNAS)
            <h1 class="font-bold text-5xl text-blue-500">Rp{{ number_format($currentPaket->getNominal(), 0, ',', '.')
                }},00</h1>
            @else
            <h1 class="font-bold text-5xl text-blue-500">Rp{{ number_format($currentPaket->getUnpayedNominal(), 0, ',', '.')
                }},00</h1>
            @endif
            <div class="text-left mx-2 px-2">
                <h2 class="text-2xl">Rincian Tagihan : </h2>
                <ul class="list-decimal">
                    @if($currentPaket->status_tagihan == App\Enums\StatusTagihan::LUNAS)
                    @foreach($currentPaket->subtagihan as $subtagihan)
                    <li>
                        <div class="flex justify-between">
                            <span>
                                {{ $subtagihan->keterangan }}
                            </span>
                            <span>
                                Rp{{ number_format($subtagihan->nominal, 0, ',', '.') }}
                            </span>
                        </div>
                    </li>
                    @endforeach
                    @else
                    @foreach($currentPaket->subtagihan()->where('terbayar', false)->get() as $subtagihan)
                    <li>
                        <div class="flex justify-between">
                            <span>
                                {{ $subtagihan->keterangan }}
                            </span>
                            <span>
                                Rp{{ number_format($subtagihan->nominal, 0, ',', '.') }}
                            </span>
                        </div>
                    </li>
                    @endforeach
                    @endif
                </ul>
            </div>
            <h1 class=" text-2xl font-bold text-left">Status :
                @if ($currentPaket->status_tagihan == App\Enums\StatusTagihan::TERLAMBAT)
                <span class="text-red-500">TERLAMBAT</span>
                @elseif ($currentPaket->status_tagihan == App\Enums\StatusTagihan::BELUM_BAYAR)
                <span class="text-yellow-500">BELUM DIBAYAR</span>
                @elseif ($currentPaket->status_tagihan == App\Enums\StatusTagihan::LUNAS)
                <span class="text-green-600">LUNAS</span>
                @else
                <span>{{ $currentPaket->status_tagihan }}</span>
                <td class="border-2 border-black">Error {{ $currentPaket->status_tagihan }}</td>
                @endif
            </h1>
            <h3 class="text-2xl">Bayar tagihan anda sebelum tanggal {{ auth()->user()->pelanggan->tanggal_jatuh_tempo }}
                disetiap bulannya</h3>
        </div>

        <div class="flex flex-col gap-2 bg-white p-2 m-2 text-center">
            <h2 class="font-bold text-xl">PENGUMUMAN!!!</h2>
            <span class="text-gray-600">
                {{ $pengumuman }}
            </span>
        </div>

        <div class="flex flex-col gap-2 bg-white p-2 m-2 text-center">
            <h2 class="font-bold text-xl">STATUS KONEKSI SERVER</h2>
            @if($status == "Normal")
            <span class="text-green-500">{{ $status }}</span>
            @else
            <span class="text-red-500">{{ $status }}</span>
            @endif
        </div>
    </div>
    @endrole

    @role('koordinator')
    <div class="flex flex-col gap-4 w-full">
        <div class="flex flex-col gap-2 bg-white p-2 m-2 text-center">
            <h2 class="font-bold text-xl">PENGUMUMAN!!!</h2>
            <span class="text-gray-600">
                {{ $pengumuman }}
            </span>
        </div>

        <div class="flex flex-col gap-2 bg-white p-2 m-2 text-center">
            <h2 class="font-bold text-xl">STATUS KONEKSI SERVER</h2>
            @if($status == "Normal")
            <span class="text-green-500">{{ $status }}</span>
            @else
            <span class="text-red-500">{{ $status }}</span>
            @endif
        </div>

        <div class="flex flex-col gap-2 bg-white p-2 m-2 text-center">
            <h2 class="font-bold text-xl">RIWAYAT PEMBAYARAN</h2>
            <form action="" class="flex gap-4 border-t-2 border-b-2 border-gray-500 p-2 m-2">
                <span class="font-bold">Bulan / Tahun : </span>
                <select name="bulan" id="bulan" onchange="this.form.submit()">
                    @foreach($months as $month)
                    <option value="{{ $month['date']->month }}" {{ $month['selected'] ? 'selected="selected"' : '' }}>{{
                        $month['date']->translatedFormat('F') }}</option>
                    @endforeach
                </select>

                <select name="tahun" id="tahun" onchange="this.form.submit()">
                    @foreach($years as $year)
                    @if($year->year == $selectedYear)
                    <option value="{{ $year->year }}" selected="selected">{{ $year->year }}</option>
                    @else
                    <option value="{{ $year->year }}">{{ $year->year }}</option>
                    @endif
                    @endforeach
                </select>
            </form>

            <ul class="flex flex-col gap-2 divide-y-2 divide-gray-500  p-2">
                @foreach($tagihan as $data)
                <li>
                    <div class="flex gap-2">
                        <div class="flex flex-col gap-2">
                            <span class="text-left">{{ $data->tagihan->pelanggan->nama }}</span>
                            <div class="flex gap-2">
                                <span>No Pelanggan : </span>
                                <span class="text-blue-500">{{ $data->tagihan->pelanggan->id }}</span>
                            </div>
                            <span class="text-gray-500">{{ $data->tagihan->pelanggan->areaAlamat->nama }}</span>
                        </div>
                        <div class="flex gap-2 text-left">
                            <span class="text-pink-600">Tagihan : </span>
                            <span class="text-blue-600">
                                {{ $data->tanggal_pengajuan->translatedFormat("F") }}
                            </span>
                        </div>
                        <div class="flex flex-col gap-1 ml-auto">
                            <span>
                                Rp{{ number_format($data->getNominal(), 0, ',', '.') }},00
                            </span>

                            @if($data->status_pengajuan == App\Enums\StatusPengajuan::PENDING)
                            <span class="text-yellow-500 font-bold text-2xl px-2">
                                PENDING
                            </span>
                            @elseif($data->status_pengajuan == App\Enums\StatusPengajuan::DITOLAK)
                            <span class="text-red-500 font-bold text-2xl px-2">
                                DITOLAK
                            </span>
                            @elseif($data->status_pengajuan == App\Enums\StatusPengajuan::SUKSES)
                            <span class="text-green-500 font-bold text-2xl px-2">
                                SUKSES
                            </span>
                            @else
                            {{ $data->status_pengajuan }}
                            @endif
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endrole

</x-layout.dashboard>
