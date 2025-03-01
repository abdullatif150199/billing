<x-layout.dashboard>
    <main class="flex flex-col justify-center items-center gap-4 w-full">
        <img src="{{ asset('images/logo-whatsapp.png') }}" alt="WA" class="w-48">
        <h2 class="text-3xl">CUSTOMER SERVICE</h2>
        <h1 class="text-5xl">{{ $noTelpon }}</h1>
        <h4 class="text-red-600 text-2xl">
            Whatsapp chat only
        </h4>
        <a href="https://wa.me/{{ $noTelpon }}">
            <img src="{{ asset('images/logo-wa-only.png') }}" alt="WA Only" class="w-12">
        </a>
    </main>
</x-layout.dashboard>
