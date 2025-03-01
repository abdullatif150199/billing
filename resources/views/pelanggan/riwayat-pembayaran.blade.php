<x-layout.dashboard>
    <div class="w-full p-3">
        <h1 class="font-bold text-3xl text-center">RIWAYAT PEMBAYARAN</h1>
        <form action="{{ route('riwayat-pembayaran') }}" class="flex gap-2">
            <label for="tahun" class="font-bold">Tahun : </label>
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
        <div class="flex flex-col py-2">
            <table class="border-t-2 border-gray-500">
                @foreach($riwayat as $data)
                <tr class="w-full border-b-2 border-gray-500">
                    <td class="py-2">{{ $data->tanggal_tagihan->translatedFormat('F') }}</td>

                    @if ($data->status_tagihan == App\Enums\StatusTagihan::TERLAMBAT)
                    <td class="py-2 text-red-600 text-center">{{ $data->status_tagihan }}</td>
                    @elseif ($data->status_tagihan == App\Enums\StatusTagihan::BELUM_BAYAR)
                    <td class="py-2 text-yellow-600 text-center">{{ $data->status_tagihan }}</td>
                    @elseif ($data->status_tagihan == App\Enums\StatusTagihan::LUNAS)
                    <td class="py-2 text-green-600 text-center">{{ $data->status_tagihan }}</td>
                    @else
                    <td class="py-2">Error {{ $data->status_tagihan }}</td>
                    @endif
                    <td class="py-2 text-right">Rp{{ number_format($data->getNominal(), 0, ',', '.') }},00</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-layout.dashboard>
