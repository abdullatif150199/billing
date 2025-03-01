<x-layout.dashboard>

    <div class="w-full">
        <div class="bg-orange-400 w-full">
            <form data-custom-form-get action="{{ route('tagihan.index') }}" class="flex flex-col w-full p-8 gap-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold">Bulan / Tahun : </h1>
                    <div class="flex gap-2">
                        <select data-custom-form name="bulan" id="bulan" class="text-lg p-1">
                            @foreach($months as $month)
                            <option value="{{ $month['date']->month }}" {{ $month['selected'] ? 'selected="selected"'
                                : '' }}>{{ $month['date']->translatedFormat('F') }}</option>
                            @endforeach
                        </select>
                        <select data-custom-form name="tahun" id="tahun" class="text-lg p-1">
                            @foreach($years as $year)
                            @if($year->year == $selectedYear)
                            <option value="{{ $year->year }}" selected="selected">{{ $year->year }}</option>
                            @else
                            <option value="{{ $year->year }}">{{ $year->year }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <button>
                        <img src="{{ asset('images/cari-putih.png') }}" alt="Cari" class="w-8">
                    </button>
                </div>

                <div class="flex justify-between items-center gap-4">
                    <div class="flex justify-center items-center gap-4 w-full">
                        <button type="submit">
                            <img src="{{ asset('images/cari-hitam.png') }}" alt="pencarian" class="h-6">
                        </button>
                        <input data-custom-form type="text" name="namaNId" placeholder="Cari Nama/ID Pelanggan" class="border-b-2 border-white p-2 w-full bg-transparent">
                    </div>

                    <div class="flex justify-center items-center gap-2 w-full">
                        <select data-custom-form name="alamat" id="alamat" class="p-2 w-full bg-transparent border-b-2 border-white text-right">
                            @if($alamatId == null)
                            <option value="" hidden selected disabled>Filter Alamat</option>
                            @else
                            <option value="">Filter Alamat</option>
                            @endif
                            @foreach($alamat as $data)
                            @if($data->id == $alamatId)
                            <option value="{{ $data->id }}" selected>{{ $data->nama }}</option>
                            @else
                            <option value="{{ $data->id }}">{{ $data->nama }}</option>
                            @endif
                            @endforeach
                        </select>
                        <button type="submit">
                            <img src="{{ asset('images/filter.png') }}" alt="pencarian" class="h-6">
                        </button>
                    </div>
                </div>
            </form>
        </div>

        @if(session()->has('message') && session()->get('message')['status'] == 'failed')
        <div class="flex flex-col gap-2">
            <span class="bg-red-500 text-white p-2 rounded">{{ session()->get('message')['message'] }}</span>
        </div>
        @endif

        <div class="w-full p-4">
            <table class="w-full table-auto">
                <thead class="bg-yellow-500">
                    <tr class="text-center">
                        <td class="border-2 border-black">
                            <a href="{{ route('tagihan.index', array_merge(request()->all(), ['sort' => 'nama', 'order' => ($sort == 'nama' && $order == 'asc') ? 'desc' : 'asc'])) }}" class="flex gap-1 justify-between items-center w-full">
                                Nama Pelanggan
                                <span>
                                    <svg class="h-4 w-4 text-black {{ ($sort == 'nama' && $order == 'desc') ? 'rotate-180' : 'rotate-0' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </a>
                        </td>
                        <td class="border-2 border-black px-2">
                            <a href="{{ route('tagihan.index', array_merge(request()->all(), ['sort' => 'id', 'order' => ($sort == 'id' && $order == 'asc') ? 'desc' : 'asc'])) }}" class="flex gap-1 justify-between items-center w-full">
                                ID
                                <span>
                                    <svg class="h-4 w-4 text-black {{ ($sort == 'id' && $order == 'desc') ? 'rotate-180' : 'rotate-0' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </a>
                        </td>
                        <td class="border-2 border-black px-1">
                            <a href="{{ route('tagihan.index', array_merge(request()->all(), ['sort' => 'area', 'order' => ($sort == 'area' && $order == 'asc') ? 'desc' : 'asc'])) }}" class="flex gap-1 justify-between items-center w-full">
                                Area / Alamat
                                <span>
                                    <svg class="h-4 w-4 text-black {{ ($sort == 'area' && $order == 'desc') ? 'rotate-180' : 'rotate-0' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </a>
                        </td>
                        <td class="border-2 border-black px-2">
                            <a href="{{ route('tagihan.index', array_merge(request()->all(), ['sort' => 'tagihan', 'order' => ($sort == 'tagihan' && $order == 'asc') ? 'desc' : 'asc'])) }}" class="flex gap-1 justify-between items-center w-full">
                                Tagihan
                                <span>
                                    <svg class="h-4 w-4 text-black {{ ($sort == 'tagihan' && $order == 'desc') ? 'rotate-180' : 'rotate-0' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </a>
                        </td>
                        <td class="border-2 border-black">
                            <a href="{{ route('tagihan.index', array_merge(request()->all(), ['sort' => 'status', 'order' => ($sort == 'status' && $order == 'asc') ? 'desc' : 'asc'])) }}" class="flex gap-1 justify-between items-center w-full">
                                Status
                                <span>
                                    <svg class="h-4 w-4 text-black {{ ($sort == 'status' && $order == 'desc') ? 'rorate-180' : 'rotate-0' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </a>
                        </td>
                        <td class="border-2 border-black">Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tagihan as $data)
                    <tr>
                        <td class="border-2 border-black">{{ $data->pelanggan->nama }}</td>
                        <td class="border-2 border-black px-2">{{ $data->pelanggan->id }}</td>
                        <td class="border-2 border-black px-1">{{ $data->pelanggan->areaAlamat->nama }}</td>
                        <td class="border-2 border-black px-2">{{ number_format($data->getNominal(), 0, ',', '.') }}
                        </td>
                        @if ($data->status_tagihan == App\Enums\StatusTagihan::TERLAMBAT)
                        <td class="border-2 border-black text-red-600">TERLAMBAT</td>
                        @elseif ($data->status_tagihan == App\Enums\StatusTagihan::BELUM_BAYAR)
                        <td class="border-2 border-black text-yellow-600">BELUM BAYAR</td>
                        @elseif ($data->status_tagihan == App\Enums\StatusTagihan::LUNAS)
                        <td class="border-2 border-black text-green-600">LUNAS</td>
                        @else
                        <td class="border-2 border-black">Error {{ $data->status_tagihan }}</td>
                        @endif
                        <td class="border-2 border-black h-full">
                            <div class="flex md:flex-row flex-col justify-evenly items-center gap-2 w-full">
                                @if ($data->status_tagihan == App\Enums\StatusTagihan::LUNAS)
                                <form action="{{ route('tagihan.batal', ['tagihan' => $data->id]) }}" method="post">
                                    @csrf
                                    <button type="submit">
                                        <img src="{{ asset('images/tolak-pengajuan.png') }}" alt="Batal" class="w-7 h-7">
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('tagihan.bayar', ['tagihan' => $data->id]) }}" method="post">
                                    @csrf
                                    <button type="submit">
                                        <img src="{{ asset('images/bayar.png') }}" alt="Bayar" class="w-7 h-7 mt-[1px]">
                                    </button>
                                </form>
                                @endif
                                <a href="{{ route('tagihan.show', ['tagihan' => $data->id]) }}">
                                    <img src="{{ asset('images/edit-ungu.png') }}" alt="Edit" class="w-7 h-7 mb-[1px]">
                                </a>
                                <a href="https://wa.me/{{ $data->pelanggan->user->no_telpon }}">
                                    <img src="{{ asset('images/logo-whatsapp.png') }}" alt="Riwayat" class="w-7 h-7">
                                </a>
                                <a href="{{ route('tagihan.riwayat', ['pelanggan' => $data->pelanggan->id, 'tahun' => $selectedYear]) }}">
                                    <img src="{{ asset('images/riwayat-tagihan.png') }}" alt="Riwayat" class="w-7 h-7">
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-layout.dashboard>
