<x-layout.dashboard>
    <div class="flex flex-col items-center gap-3 w-full p-8">
        <h1 class="text-center text-3xl">LAPORAN KEUANGAN</h1>
        <div class="flex gap-2 w-full p-2 border-t-2 border-b-2 border-black">
            <span>Bulan / Tahun : </span>
            <form action="" class="flex gap-4">
                <select name="bulan" id="bulan" onchange="this.form.submit()">
                    @foreach($months as $month)
                    <option value="{{ $month['date']->month }}" {{ $month['selected'] ? 'selected="selected"' : '' }}>{{ $month['date']->translatedFormat('F') }}</option>
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
        </div>
        <div class="flex justify-between items-center gap-2 w-full">
            <div class="flex flex-col">
                <h2 class="text-2xl">Total Penerimaan</h2>
                <span class="text-2xl text-pink-500">Rp {{ number_format($pendapatan, 0, ',', '.') }},00</span>
            </div>

            <div class="flex flex-col">
                <h2 class="text-2xl">Total Pengeluaran</h2>
                <span class="text-2xl text-red-500">Rp {{ number_format($pengeluaranSum, 0, ',', '.') }},00</span>
            </div>

            <div class="flex flex-col">
                <h2 class="text-2xl">Pendapatan Bersih</h2>
                <span class="text-2xl text-green-500">Rp {{ number_format($pendapatan - $pengeluaranSum, 0, ',', '.') }},00</span>
            </div>
        </div>

        <form action="{{ route('pengeluaran.store') }}" method="post" class="flex flex-col gap-1 w-full">
            @csrf
            <div class="flex gap-4 justify-between items-center">
                <span class="text-2xl">Pengeluaran</span>
                <input type="hidden" name="tahun" value="{{ request()->get('tahun', now()->year) }}">
                <input type="hidden" name="bulan" value="{{ request()->get('bulan', now()->month) }}">
                <input type="text" name="nama" placeholder="Nama Pengeluaran" class="w-full border-b-[1px] border-black bg-transparent" required>
                <input type="number" name="total" placeholder="Anggaran, cth: 50000" class="w-[42%] border-b-[1px] border-black bg-transparent" required>
                <button type="submit">
                    <img src="{{ asset('images/tambah.png') }}" alt="Tambah" class="w-12">
                </button>
            </div>
        </form>

        <div class="flex flex-col gap-2 h-[28vh] w-full py-1 px-5 border-4 border-black ">
            <ol class="list-decimal flex flex-col gap-3 w-full">
                @foreach($pengeluaran as $data)
                <li>
                    <div class="flex justify-between items-center">
                        <span>{{ $data->nama }}</span>
                        <div class="flex items-center gap-4">
                            <span>
                                Rp {{number_format($data->total, 0, ',', '.')}},00
                            </span>
                            <form action="{{ route('pengeluaran.destroy', ['pengeluaran' => $data->id]) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit">
                                    <img src="{{ asset('images/hapus.png') }}" alt="Hapus" class="w-4">
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
                @endforeach
            </ol>
        </div>
    </div>
</x-layout.dashboard>
