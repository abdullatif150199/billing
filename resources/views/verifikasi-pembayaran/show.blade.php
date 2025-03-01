<x-layout.dashboard>
    <div class="flex flex-col gap-4 w-full">
        <h1 class="text-3xl text-center">VERIFIKASI PEMBAYARAN KASIR / KOORDINATOR / MITRA : {{ $kasir->id }}</h1>
        <ul class="flex flex-col gap-2 w-full p-4">

            @if(session()->has('message') && session()->get('message')['status'] == 'failed')
            <div class="flex flex-col gap-2">
                <span class="bg-red-500 text-white p-2 rounded">{{ session()->get('message')['message'] }}</span>
            </div>
            @endif

            @foreach($tagihan as $data)
            <li class="flex justify-between bg-white p-3 w-full">
                <div class="flex flex-col gap-2">
                    <span>
                        {{ $data->tagihan->pelanggan->nama }}
                    </span>
                    <div class="flex justify-between gap-3">
                        <span class="text-pink-500">
                            No Pelanggan :
                        </span>
                        <span class="text-blue-500">{{ $data->tagihan->pelanggan->id }}</span>
                        <span class="text-pink-500">Tagihan : </span>
                        <span class="text-blue-500">{{ $data->tagihan->tanggal_tagihan->translatedFormat("F") }}</span>
                    </div>
                    <span class="text-gray-500">{{ $data->tagihan->pelanggan->areaAlamat->nama }}</span>
                </div>
                <div class="flex flex-col justify-between gap-2">
                    <h2 class="text-xl">
                        Rp{{ number_format($data->getNominal(), 0, ',', '.') }},00
                    </h2>
                    <div class="flex justify-between items-center gap-3">
                        <form action="{{ route('verifikasi-pembayaran.store', ['kasir' => $kasir->id, 'pembayaran' => $data->id]) }}" method="post">
                            @csrf
                            <button type="submit">
                                <img src="{{ asset('images/bayar.png') }}" alt="Bayar" class="w-10">
                            </button>
                        </form>

                        <form action="{{ route('verifikasi-pembayaran.store', ['kasir' => $kasir->id, 'pembayaran' => $data->id]) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit">
                                <img src="{{ asset('images/tolak-pengajuan.png') }}" alt="Tolak" class="w-8">
                            </button>
                        </form>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</x-layout.dashboard>
