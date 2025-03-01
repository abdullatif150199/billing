<x-layout.dashboard>
    <main class="w-full">
        <div class="flex flex-col gap-4 bg-yellow-500 w-full p-4">
            <h1 class="text-center text-3xl">EDIT TAGIHAN</h1>
            <div class="flex w-full">
                <table>
                    <tr>
                        <td>Nama Pelanggan</td>
                        <td class="px-2">:</td>
                        <td>{{ $tagihan->pelanggan->nama }}</td>
                    </tr>

                    <tr>
                        <td>ID Pelanggan</td>
                        <td class="px-2">:</td>
                        <td>{{ $tagihan->pelanggan->id }}</td>
                    </tr>

                    <tr>
                        <td>Bulan /Tahun</td>
                        <td class="px-2">:</td>
                        <td>{{ $tagihan->tanggal_tagihan->translatedFormat("F Y") }}</td>
                    </tr>
                </table>
            </div>
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

        @if(session()->has('message') && session()->get('message')['status'] == 'failed')
        <div class="flex flex-col gap-2">
            <span class="bg-red-500 text-white p-2 rounded">{{ session()->get('message')['message'] }}</span>
        </div>
        @endif

        <div class="flex flex-col gap-8 p-4">
            <form action="{{ route('tagihan.subtagihan.store', ['tagihan' => $tagihan]) }}" class="flex gap-4 w-full" method="post">
                @csrf
                <label for="keterangan" class="text-xl w-[400px]">Tambah Tagihan : </label>
                <input type="text" name="keterangan" id="keterangan" class="border-b-2 border-black p-[2px] w-full bg-transparent" placeholder="Nama Tagihan">
                <input type="number" name="nominal" id="nominal" class="border-b-2 border-black p-[2px] w-full bg-transparent" placeholder="Nominal, cth: 50000">
                <button type="submit">
                    <img src="{{ asset('images/tambah-tagihan.png') }}" alt="Tambah" class="w-12">
                </button>
            </form>

            @if($tagihan->status_tagihan != App\Enums\StatusTagihan::LUNAS)
            <form action="{{ route('tagihan.subtagihan.store', ['tagihan' => $tagihan, 'negative' => true]) }}" class="flex gap-4 w-full" method="post">
                @csrf
                <label for="keterangan" class="text-xl w-[400px]">Kurangi Tagihan : </label>
                <input type="text" name="keterangan" id="keterangan" class="border-b-2 border-black p-[2px] w-full bg-transparent" placeholder="Keterangan">
                <input type="number" name="nominal" id="nominal" class="border-b-2 border-black p-[2px] w-full bg-transparent" placeholder="Nominal, cth: 50000">
                <button type="submit">
                    <img src="{{ asset('images/kurangi-tagihan.png') }}" alt="Tambah" class="w-12">
                </button>
            </form>
            @else
            <div class="flex gap-4 w-full">
                <label for="keterangan" class="text-xl w-[400px]">Kurangi Tagihan : </label>
                <input type="text" name="keterangan" id="keterangan" class="border-b-2 border-black p-[2px] w-full bg-transparent" placeholder="Keterangan" disabled>
                <input type="number" name="nominal" id="nominal" class="border-b-2 border-black p-[2px] w-full bg-transparent" placeholder="Nominal, cth: 50000" disabled>
                <span>
                    <img src="{{ asset('images/kurangi-tagihan.png') }}" alt="Tambah" class="w-12 grayscale">
                </span>
            </div>
            @endif

            <div>
                <p>Rincian Tagihan : </p>
                <div class="p-1 border-2 border-black h-[250px] overflow-auto">
                    <div class="flex flex-col">
                        <ul class="flex flex-col gap-4 list-decimal px-6">
                            @foreach ($tagihan->subtagihan as $data)
                            <li>
                                <div class="flex justify-between">
                                    <span>
                                        {{ $data->keterangan }}
                                    </span>

                                    <div class="flex gap-2">
                                        @if($data->nominal > 0)
                                        <span>Rp{{ number_format($data->nominal, 0, ',', '.') }}</span>
                                        @else
                                        <span>-Rp{{ number_format(-$data->nominal, 0, ',', '.') }}</span>
                                        @endif
                                        @if ($data->dapat_dihapus)
                                        <form action="{{ route('tagihan.subtagihan.destroy', ['tagihan' => $tagihan, 'subTagihan' => $data]) }}" method="post">
                                            @csrf
                                            @method('delete')

                                            <button type="submit">
                                                <img src="{{ asset('images/hapus.png') }}" alt="Hapus" class="w-6">
                                            </button>
                                        </form>
                                        @else
                                        <div class="w-6 h-6"></div>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div>
                <table>
                    <tr>
                        <td>Total Tagihan</td>
                        <td class="px-2">:</td>
                        <td class="text-blue-500">Rp{{ number_format($tagihan->getNominal(), 0, ',', '.') }}</td>
                    </tr>

                    <tr>
                        <td>Tagihan Belum Bayar</td>
                        <td class="px-2">:</td>
                        <td class="text-blue-500">Rp{{ number_format($tagihan->getUnpayedNominal(), 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </main>
</x-layout.dashboard>
