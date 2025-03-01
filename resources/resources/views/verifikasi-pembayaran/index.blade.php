<x-layout.dashboard>
    <div class="flex flex-col gap-4 w-full">
        <h1 class="text-3xl text-center">VERIFIKASI PEMBAYARAN KASIR / KOORDINATOR / MITRA</h1>
        <ul class="flex flex-col gap-2 w-full p-4">
            @foreach($pengaju as $data)
            <li class="bg-white p-2 w-full">
                <div class="flex justify-between w-full">
                    <div>
                        <span>{{ $data->nama }}</span>
                        <div class="flex justify-between gap-4">
                            <div>
                                <span class="text-pink-500">ID Koordinator : </span>
                                <span class="text-blue-500">{{ $data->id }}</span>
                            </div>
                            <div>
                                <span class="text-red-500">Jumlah Permintaan Tertunda : </span>
                                <span class="text-blue-500">{{ $data->pembayaran_count }}</span>
                            </div>
                        </div>
                        <span class="text-gray-500">{{ $data->areaAlamat->nama }}</span>
                    </div>

                    <div class="flex justify-center items-center gap-4">
                        <a href="{{ route('verifikasi-pembayaran.show', ['kasir' => $data->id]) }}">
                            <img src="{{ asset('images/lihat-detail-verifikasi-pembayaran.png') }}" alt="Detail" class="w-12">
                        </a>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</x-layout.dashboard>
