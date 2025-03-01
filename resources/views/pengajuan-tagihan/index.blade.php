<x-layout.dashboard>
    <main class='flex flex-col items-center w-full gap-4 p-4'>
        <header class="flex flex-col items-center justify-center gap-2">
            <img src="{{ asset('images/logo-pengajuan-pembayaran.png') }}" alt="Pengajuan Pembayaran" class="w-40">
            <h1 class="text-2xl font-bold">AJUKAN PEMBAYARAN</h1>
        </header>

        <form action="" class="flex gap-8 w-full">
            <div class="flex flex-col gap-1 w-full">
                <input type="text" name="id" id="id" placeholder="Cari ID Pelanggan" class="border-b-[1px] border-black p-2 w-full" value="{{ old('id') }}" required>
            </div>

            <button type="submit">
                <img src="{{ asset('images/cari-id-pelanggan.png') }}" alt="Cari" class="w-8">
            </button>

            <button>
                <img src="{{ asset('images/scan-barcode.png') }}" alt="Scan" class="w-8">
            </button>
        </form>

        @isset($pelanggan)
        <div class="self-left divide-y-[1px] w-full py-2">
            <table class="border-b-[1px] border-black w-full">
                <thead>
                    <tr>
                        <td>Nama Pelanggan</td>
                        <td class="px-2">:</td>
                        <td>{{ $pelanggan->nama }}</td>
                    </tr>

                    <tr>
                        <td>ID Pelanggan</td>
                        <td class="px-2">:</td>
                        <td>{{ $pelanggan->id }}</td>
                    </tr>

                    <tr>
                        <td>Alamat</td>
                        <td class="px-2">:</td>
                        <td>{{ $pelanggan->areaAlamat->nama }}</td>
                    </tr>
                </thead>
            </table>

            <h2 class="text-2xl text-center m-2">TAGIHAN YANG BELUM DIBAYAR</h2>

            <ul>
                @foreach($tagihan as $data)
                <li class="flex justify-between m-2">
                    <span>
                        @php
                        $keterangan = $data->tanggal_tagihan->translatedFormat('F');
                        if ($jumlahPembayaran >= 1) {
                        $keterangan = $data->getFirstKeterangan();
                        }
                        @endphp
                        {{ $keterangan }}
                    </span>
                    <div class="flex gap-2">
                        <span>
                            Rp{{ number_format($data->getUnpayedNominal(), 0, ',', '.') }},00
                        </span>
                        @if($data->status_pengajuan == App\Enums\StatusPengajuan::PENDING)
                        <span class="bg-yellow-500 text-white font-bold px-2">
                            PENDING
                        </span>
                        @elseif($data->status_pengajuan == App\Enums\StatusPengajuan::DITOLAK)

                        <form action="{{ route('pengajuan.store', ['tagihan' => $data->id]) }}" method="post">
                            @csrf

                            <button type="submit" class="bg-green-500 text-white font-bold px-2">
                                Ajukan
                            </button>
                        </form>
                        @elseif($data->status_pengajuan == App\Enums\StatusPengajuan::SUKSES)
                        <span class="bg-green-500 text-white font-bold px-2">
                            SUKSES
                        </span>
                        @else
                        <form action="{{ route('pengajuan.store', ['tagihan' => $data->id]) }}" method="post">
                            @csrf

                            <button type="submit" class="bg-green-500 text-white font-bold px-2">
                                Ajukan
                            </button>
                        </form>
                        @endif
                    </div>
                </li>
                @endforeach

                @foreach($pengajuan as $data)
                <li class="flex justify-between m-2">
                    <span>
                        {{ $data->keterangan }}
                    </span>
                    <div class="flex gap-2">
                        <span>
                            Rp{{ number_format($data->getNominal(), 0, ',', '.') }},00
                        </span>
                        @if($data->status_pengajuan == App\Enums\StatusPengajuan::PENDING)
                        <span class="bg-yellow-500 text-white font-bold px-2">
                            PENDING
                        </span>
                        @elseif($data->status_pengajuan == App\Enums\StatusPengajuan::DITOLAK)

                        <form action="{{ route('pengajuan.reStore', ['pembayaran' => $data->id]) }}" method="post">
                            @csrf

                            <button type="submit" class="bg-green-500 text-white font-bold px-2">
                                Ajukan
                            </button>
                        </form>
                        @elseif($data->status_pengajuan == App\Enums\StatusPengajuan::SUKSES)
                        <span class="bg-green-500 text-white font-bold px-2">
                            SUKSES
                        </span>
                        @else
                        <form action="{{ route('pengajuan.reStore', ['tagihan' => $data->id]) }}" method="post">
                            @csrf

                            <button type="submit" class="bg-green-500 text-white font-bold px-2">
                                Ajukan
                            </button>
                        </form>
                        @endif
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        @endisset
    </main>
</x-layout.dashboard>
