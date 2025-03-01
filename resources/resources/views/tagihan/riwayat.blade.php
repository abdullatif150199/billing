<x-layout.dashboard>

    <div class="w-full">
        <div class="bg-orange-400 w-full p-2">
            <div class="px-4">
                <h1 class="font-bold text-center">RIWAYAT PEMBAYARAN PELANGGAN</h1>
                <table>
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
                        <td>Area / Alamat</td>
                        <td class="px-2">:</td>
                        <td>{{ $pelanggan->areaAlamat->nama }}</td>
                    </tr>
                </table>
            </div>

            <form action="#" class="flex px-8 gap-4">
                <label for="tahun" class="text-2xl font-bold">Tahun : </label>
                <select name="tahun" id="tahun" class="text-lg p-1" onchange="console.log(this.form.submit())">
                    @foreach($years as $year)
                    @if($year->year == $selectedYear)
                    <option value="{{ $year->year }}" selected="selected">{{ $year->year }}</option>
                    @else
                    <option value="{{ $year->year }}">{{ $year->year }}</option>
                    @endif
                    @endforeach
                </select>
            </form>
        </div>
        <div class="flex justify-center items-center w-full p-4">
            <table>
                <thead>
                    <tr>
                        <td class="border-2 border-black py-1 px-8 text-xl text-center">Bulan</td>
                        <td class="border-2 border-black py-1 px-8 text-xl text-center">Tahun</td>
                        <td class="border-2 border-black py-1 px-8 text-xl text-center">Tagihan</td>
                        <td class="border-2 border-black py-1 px-12 text-xl text-center">Status</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tagihan as $data)
                    <tr>
                        <td class="border-2 border-black">{{ $data->tanggal_tagihan->translatedFormat("F") }}</td>
                        <td class="border-2 border-black text-center">{{ $data->tanggal_tagihan->year }}</td>
                        <td class="border-2 border-black text-center">{{ number_format($data->getNominal(), 0, ',', '.') }}</td>
                        @if ($data->status_tagihan == App\Enums\StatusTagihan::TERLAMBAT)
                        <td class="border-2 border-black text-red-600 text-center">{{ $data->status_tagihan }}</td>
                        @elseif ($data->status_tagihan == App\Enums\StatusTagihan::BELUM_BAYAR)
                        <td class="border-2 border-black text-yellow-600 text-center">{{ $data->status_tagihan }}</td>
                        @elseif ($data->status_tagihan == App\Enums\StatusTagihan::LUNAS)
                        <td class="border-2 border-black text-green-600 text-center">{{ $data->status_tagihan }}</td>
                        @else
                        <td class="border-2 border-black">Error {{ $data->status_tagihan }}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-layout.dashboard>
