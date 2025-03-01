<x-layout.dashboard>
    <div class="flex flex-col w-full p-8">
        <header class="flex flex-col justify-center items-center w-full">
            <img src="{{ asset('images/username.png') }}" alt="Profile" class="w-24">
            <h1 class="text-2xl">
                @role('admin')
                Akun Administrator
                @endrole
                @role('koordinator')
                Profil
                @endrole
                @role('pelanggan')
                Profil Pelanggan
                @endrole
            </h1>
        </header>

        <main class="flex flex-col justify-center items-center gap-4 w-full">
            @role('admin')
            <form enctype="multipart/form-data" action="{{ route('profile.update-admin') }}" method="post" class="flex flex-col gap-2 sm:w-[98%] md:w-[78%]">
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
                        <img src="{{ asset('images/password.png') }}" alt="" class="w-8 object-cover p-1">
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="no-wa">Nomor Whatsapp : </label>
                    <div class="flex justify-center items-center w-full border-2 border-gray-400 rounded gap-2">
                        <input id="no-wa" name="noWhatsapp" placeholder="Nomor Whatsapp" type="text" class="w-full p-2 bg-transparent" required>
                        <img src="{{ asset('images/nomor-wa.png') }}" alt="" class="w-8 object-cover p-1">
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="foto" class="flex flex-col cursor-pointer">
                        <input data-custom-file-upload="#custom-file-show" id="foto" type="file" name="foto" class="opacity-0 absolute pointer-events-none" required>
                        <span>Foto : </span>
                        <div class="flex justify-between items-center border-2 border-gray-400 py-2 pl-2 rounded">
                            <div class="flex flex-col gap-1">
                                <span class="text-gray-400" id="custom-file-show">DSC000326377.JPG</span>
                            </div>
                            <div class="flex items-end">
                                <img src="{{ asset('images/buka-folder.png') }}" alt="Upload" class="w-8 p-1">
                            </div>
                        </div>
                    </label>
                </div>

                @if(session()->has('message') && session()->get('message')['status'] == 'success')
                <div class="flex flex-col gap-2">
                    <span class="bg-green-500 text-white p-2 rounded">{{ session()->get('message')['message'] }}</span>
                </div>
                @endif

                @if(session()->has('message') && session()->get('message')['status'] == 'failed')
                <div class="flex flex-col gap-2">
                    <span class="bg-red-500 text-white p-2 rounded">{{ session()->get('message')['message'] }}</span>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="flex flex-col gap-2">
                        @foreach ($errors->all() as $error)
                        <li class="text-white bg-red-600 p-2 rounded">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="m-auto">
                    <button type="submit" class="bg-green-600 text-white py-1 px-4 text-3xl rounded">SIMPAN
                        PERUBAHAN</button>
                </div>
            </form>

            <form action="{{ route('profile.logout') }}" method="post">
                @csrf

                <div class="m-auto">
                    <button type="submit" class="bg-red-600 text-white py-1 px-4 text-3xl rounded">LOGOUT</button>
                </div>
            </form>
            @endrole

            @role('pelanggan')
            <div class="flex flex-col gap-2 self-start py-2 px-12">
                <table>
                    <tr>
                        <td>Nama Pelanggan</td>
                        <td class="px-4">:</td>
                        <td>{{ auth()->user()->pelanggan->nama }}</td>
                    </tr>

                    <tr>
                        <td>ID Pelanggan</td>
                        <td class="px-4">:</td>
                        <td>{{ auth()->user()->pelanggan->id }}</td>
                    </tr>

                    <tr>
                        <td>Area / Alamat</td>
                        <td class="px-4">:</td>
                        <td>{{ auth()->user()->pelanggan->areaAlamat->nama }}</td>
                    </tr>
                </table>
            </div>
            <form action="{{ route('profile.update-koordinator') }}" method="post" class="flex flex-col gap-2 sm:w-[98%] md:w-[78%]">
                @csrf

                <div class="flex flex-col gap-1">
                    <label for="no-wa">Nomor Whatsapp : </label>
                    <div class="flex justify-center items-center w-full border-2 border-gray-400 rounded gap-2">
                        <input id="no-wa" name="noWhatsapp" placeholder="Nomor Whatsapp" type="text" class="w-full p-2 bg-transparent" value="{{ auth()->user()->no_telpon }}" required>
                        <img src="{{ asset('images/nomor-wa.png') }}" alt="" class="w-8 object-cover p-1">
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="username">Username : </label>
                    <div class="flex justify-center items-center w-full border-2 border-gray-400 rounded gap-2">
                        <input id="username" name="name" placeholder="{{ auth()->user()->name }}" type="text" class="w-full p-2 bg-transparent" value="{{ auth()->user()->name }}" required>
                        <img src="{{ asset('images/username.png') }}" alt="" class="w-8 object-cover p-1">
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="password">Password : </label>
                    <div class="flex justify-center items-center w-full border-2 border-gray-400 rounded gap-2">
                        <input id="password" name="password" placeholder="Password" type="text" class="w-full p-2 bg-transparent" value="{{ auth()->user()->password_not_hashed }}" required>
                        <img src="{{ asset('images/password.png') }}" alt="" class="w-8 object-cover p-1">
                    </div>
                </div>

                @if(session()->has('message') && session()->get('message')['status'] == 'success')
                <div class="flex flex-col gap-2">
                    <span class="bg-green-500 text-white p-2 rounded">{{ session()->get('message')['message'] }}</span>
                </div>
                @endif

                @if(session()->has('message') && session()->get('message')['status'] == 'failed')
                <div class="flex flex-col gap-2">
                    <span class="bg-red-500 text-white p-2 rounded">{{ session()->get('message')['message'] }}</span>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="flex flex-col gap-2">
                        @foreach ($errors->all() as $error)
                        <li class="text-white bg-red-600 p-2 rounded">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="m-auto">
                    <button type="submit" class="bg-green-600 text-white py-1 px-4 text-3xl rounded">SIMPAN
                        PERUBAHAN</button>
                </div>
            </form>
            <form action="{{ route('profile.logout') }}" method="post">
                @csrf

                <div class="m-auto">
                    <button type="submit" class="bg-red-600 text-white py-1 px-4 text-3xl rounded">LOGOUT</button>
                </div>
            </form>
            @endrole

            @role('koordinator')
            <form action="{{ route('profile.update-koordinator') }}" method="post" class="flex flex-col gap-2 sm:w-[98%] md:w-[78%]">
                @csrf

                <div class="flex flex-col gap-1">
                    <label for="no-wa">Nomor Whatsapp : </label>
                    <div class="flex justify-center items-center w-full border-2 border-gray-400 rounded gap-2">
                        <input id="no-wa" name="noWhatsapp" placeholder="Nomor Whatsapp" type="text" class="w-full p-2 bg-transparent" value="{{ auth()->user()->no_telpon }}" required>
                        <img src="{{ asset('images/nomor-wa.png') }}" alt="" class="w-8 object-cover p-1">
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="username">Username : </label>
                    <div class="flex justify-center items-center w-full border-2 border-gray-400 rounded gap-2">
                        <input id="username" name="name" placeholder="{{ auth()->user()->name }}" type="text" class="w-full p-2 bg-transparent" value="{{ auth()->user()->name }}" required>
                        <img src="{{ asset('images/username.png') }}" alt="" class="w-8 object-cover p-1">
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="password">Password : </label>
                    <div class="flex justify-center items-center w-full border-2 border-gray-400 rounded gap-2">
                        <input id="password" name="password" placeholder="Password" type="text" class="w-full p-2 bg-transparent" value="{{ auth()->user()->password_not_hashed }}" required>
                        <img src="{{ asset('images/password.png') }}" alt="" class="w-8 object-cover p-1">
                    </div>
                </div>

                @if(session()->has('message') && session()->get('message')['status'] == 'success')
                <div class="flex flex-col gap-2">
                    <span class="bg-green-500 text-white p-2 rounded">{{ session()->get('message')['message'] }}</span>
                </div>
                @endif

                @if(session()->has('message') && session()->get('message')['status'] == 'failed')
                <div class="flex flex-col gap-2">
                    <span class="bg-red-500 text-white p-2 rounded">{{ session()->get('message')['message'] }}</span>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="flex flex-col gap-2">
                        @foreach ($errors->all() as $error)
                        <li class="text-white bg-red-600 p-2 rounded">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="m-auto">
                    <button type="submit" class="bg-green-600 text-white py-1 px-4 text-3xl rounded">SIMPAN
                        PERUBAHAN</button>
                </div>
            </form>
            <form action="{{ route('profile.logout') }}" method="post">
                @csrf

                <div class="m-auto">
                    <button type="submit" class="bg-red-600 text-white py-1 px-4 text-3xl rounded">LOGOUT</button>
                </div>
            </form>
            @endrole
        </main>
    </div>

</x-layout.dashboard>
