<x-layout.dashboard>
    <main class="flex flex-col items-center gap-2 w-full">
        <img src="{{ asset('images/akun-mikrotik.png') }}" alt="Mikrotik">
        <h2 class="text-2xl">AKUN MIKROTIK</h2>
        <form action="{{ route('mikrotik.update') }}" method="post" class="flex flex-col gap-2 w-[60%]">
            @csrf

            <div class="flex flex-col gap-1">
                <label for="ip">IP Address : </label>
                <div class="flex justify-center items-center w-full border-2 border-gray-400 rounded gap-2">
                    <input id="ip" name="ip" placeholder="contoh: 103.12.34.12" type="text" class="w-full p-2 bg-transparent" value="{{ $mikrotik['ip'] }}" required>
                    <img src="{{ asset('images/ip.png') }}" alt="" class="w-8 h-8 object-cover p-1">
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label for="port">Port : </label>
                <div class="flex justify-center items-center w-full border-2 border-gray-400 rounded gap-2">
                    <input id="port" name="port" placeholder="contoh: 8721" type="text" class="w-full p-2 bg-transparent" value="{{ $mikrotik['port'] }}" required>
                    <div class="w-8 h-8 flex justify-center items-center">
                        <img src="{{ asset('images/port.png') }}" alt="" class="object-cover">
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label for="username">Username : </label>
                <div class="flex justify-center items-center w-full border-2 border-gray-400 rounded gap-2">
                    <input id="username" name="username" placeholder="contoh: admin" type="text" class="w-full p-2 bg-transparent" value="{{ $mikrotik['username'] }}" required>
                    <img src="{{ asset('images/username.png') }}" alt="" class="w-8 h-8 object-cover p-1">
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label for="password">Password : </label>
                <div class="flex justify-center items-center w-full border-2 border-gray-400 rounded gap-2">
                    <input id="password" name="password" placeholder="contoh: admin" type="password" class="w-full p-2 bg-transparent" required>
                    <div class="w-8 h-8 p-1 flex justify-center items-center">
                        <img src="{{ asset('images/password.png') }}" alt="" class="object-cover">
                    </div>
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

            <div class="flex justify-center items-center w-full">
                <button type="submit" class="text-white bg-green-500 p-2 text-3xl rounded">SIMPAN</button>
            </div>
        </form>
    </main>
</x-layout.dashboard>
