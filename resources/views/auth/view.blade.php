<x-layout.default-layout>

    <div class="min-w-screen min-h-screen flex justify-center items-center bg-stratos-950">
        <div class="flex flex-col gap-4 p-4 rounded bg-white lg:min-w-[28vw] md:min-w-[42vw] sm:min-w-[92vw]">
            <header class="p-8">
                <img src="{{ asset(Storage::url(App\Models\DataMaster::where('nama', 'logo')->first()->data)) }}" alt="Logo" class="flex justify-center items-center text-2xl w-full h-24 bg-gray-200 object-cover text-center">
            </header>

            <form method="post" action="{{ route('login.post') }}" class="flex flex-col gap-4">
                @csrf

                <div class="flex flex-col gap-1">
                    <label for="username">Username : </label>
                    <div class="flex justify-center items-center w-full border-2 border-gray-400 rounded gap-2">
                        <input id="username" name="name" placeholder="Username" type="text" class="w-full p-2 bg-transparent" required>
                        <img src="{{ asset('images/username.png') }}" alt="" class="w-8 h-8 object-cover p-1">
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="password">Password : </label>

                    <div class="flex justify-center items-center w-full border-2 border-gray-400 rounded gap-2">
                        <input id="password" name="password" placeholder="Password" type="password" class="w-full p-2 bg-transparent" required>
                        <img src="{{ asset('images/password.png') }}" alt="" class="w-8 p-1 object-cover">
                    </div>
                </div>

                @if(session()->has('message') && session()->get('message')['status'] == 'failed')
                <div class="flex flex-col gap-2">
                    <span class="bg-red-500 text-white p-2 rounded">{{ session()->get('message')['message'] }}</span>
                </div>
                @endif

                <div class="flex flex-col justify-center items-center m-auto p-4">
                    <label for="login">LOGIN</label>
                    <button type="submit" class="bg-green-500">
                        <img src="{{ asset('images/login.png') }}" alt="Login" class="w-16">
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-layout.default-layout>
