@extends('layouts.app')

@section('content')
    <div x-data="{ map: false, toggle() { this.map = !this.map } }" class="px-4 lg:px-0 md:px-0">
        <div
            class="w-full
            bg-gradient-to-r from-pest-search-purple to-pest-search-rose 
            lg:rounded-none md:rounded-none rounded-lg 
            px-20 lg:px-[14.5%] mx-auto 
            sm:py-6 md:py-10 lg:py-10 py-6
            block lg:grid md:grid sm:block
            lg:grid-cols-3 md:grid-cols-3
            gap-x-20">

            <div class="md:grid lg:grid sm:hidden hidden col-span-2">
                <section class="bg-transparent grid md:grid-cols-3 grid-cols-1 gap-2">
                   @if ($pest)
                        <input type="text"
                            class="w-full px-4 py-2 text-sm leading-tight text-gray-700 border rounded-md appearance-none focus:outline-none border-none focus:ring-0 focus:shadow-xl h-10 disabled:bg-white disabled:opacity-90 disabled:text-black"
                            placeholder="{{ $pest->name . ' in ' . strtoupper($postcode) }}" disabled />

                        @include('components.general.button', [
                            'attributes' => 'bg-pest-cyprus',
                            'text' => 'New Search',
                            'route' => '/',
                        ])
                    @endif
                </section>
            </div>

            {{-- Show map should show this provider on the map --}}
            <div></div>
            {{-- <button @click="toggle()"
                class="bg-pest-rose w-full mx-auto my-auto text-white h-10 rounded-md flex flex-row justify-center py-2">
                <span x-text="map ? 'Hide Map' : 'Show Map'"></span>
            </button> --}}

            {{-- Extended gradient BG --}}
            <div class="h-80"></div>
        </div>

        <div
            class='w-full grid py-4 lg:px-[14.5%]
                    grid-cols-1 lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1
                    gap-x-10 pb-20 mx-auto 
                    bg-pest-aliceblue
                    px-20'>

            {{-- Provider contact --}}
            @include('components.primary.providerdetails', ['provider' => $provider])
            {{-- Provider details tab --}}
            @include('components.primary.providerdetailstab', ['provider' => $provider])
        </div>


    </div>

    <x-footer-controller />
@endsection

@section('scripts')
@endsection
