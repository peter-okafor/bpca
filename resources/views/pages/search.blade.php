@extends('layouts.app')

@section('content')
    <div x-data="{ map: false, toggle() { this.map = !this.map } }" class="px-4 lg:px-0 md:px-0">
        <div
            class="w-full 
            bg-gradient-to-r from-pest-search-purple to-pest-search-rose 
            lg:rounded-none md:rounded-none rounded-lg 
            px-container_others lg:px-container_lg md:px-container_md sm:px-container_sm 
            sm:py-6 md:py-10 lg:py-10 py-6
            block lg:grid md:grid sm:block
            lg:grid-cols-3 md:grid-cols-3
            gap-x-20">

            <div class="md:grid lg:grid sm:hidden hidden col-span-2">
                <section class="bg-transparent grid md:grid-cols-3 grid-cols-1 gap-2">
                    {{-- No pest selected. --}}
                    {{-- <input type="text"
                        class="w-full px-4 py-2 text-sm leading-tight text-gray-700 border rounded-md appearance-none focus:outline-none border-none focus:ring-0 focus:shadow-xl h-10 disabled:bg-white disabled:opacity-90 disabled:text-black"
                        placeholder="Pest type" /> --}}

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

            <button @click="toggle()"
                class="bg-pest-rose w-full md:w-32 lg:w-full mx-auto my-auto text-white h-10 rounded-md flex flex-row justify-center py-2">
                <span x-text="map ? 'Hide Map' : 'Show Map'"></span>
            </button>
        </div>


        {{-- Maps --}}
        <div x-show="map" id="map" class="w-full h-80 bg-gray-100">
        </div>

        {{-- Provider List --}}
        <section
            {{-- class="w-full pt-10 bg-pest-aliceblue rounded-md px-container_others lg:px-container_lg md:px-container_md sm:px-container_sm grid gap-6 lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-1 grid-cols-1 pt-6 pb-6 min-h-[70px] justify-between"> --}}
            class="grid gap-10 md:p-20 px-6 py-10 w-full mx-auto bg-pest-aliceblue md:grid-cols-3 lg:grid-cols-4">

            {{-- Provider Card --}}
            @forelse ($paginator as $org)
                {{-- {{ dd($org[]) }} --}}
                <div class='col-span-1 flex flex-col'>
                    @include('components.primary.providercard', [
                        'name' => $org['name'] ?? '',
                        'slug' => $org['slug'] ?? '',
                        'address' => $org['address_1'] . ', ' . $org['postcode'],
                        'src' => asset('/images/BPCA-member-logo-400-400.png'),
                        'email' => $org['email'] ?? '',
                        'phone' => $org['phone'] ?? '',
                        'external_id' => $org['external_id'] ?? '',
                    ])
                </div>
            @empty
                <x-expand-search />
            @endforelse
        </section>

        {{-- Pagination Links --}}
        <div class="px-10 py-4">
            {{ $paginator->links() }}
        </div>

        {{-- Article Section --}}
        <div
            class="py-6 grid gap-x-10 px-container_others lg:px-container_lg md:px-container_md sm:px-container_sm grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 md:grid-cols-2">
            @component('components.primary.article', ['style' => 'pt-6 pb-10 my-6 px-10 col-span-1 place-self-start', 'title' => $city->name ?? ''])
                <div class='mb-7 space-y-2 text-sm font-light'>
                    {!! $city->description ?? '' !!}
                </div>

                {{-- @include('components.general.button', [
                    'attributes' => 'bg-pest-rose',
                    'text' => 'Show Map',
                ]) --}}

                <button @click="toggle()"
                    class="bg-pest-rose w-full mx-auto my-auto text-white h-10 rounded-md flex flex-row justify-center py-2">
                    <span x-text="map ? 'Hide Map' : 'Show Map'"></span>
                </button>
            @endcomponent

            @if ($pest)
                @component('components.primary.article', ['style' => 'pt-6 pb-10 my-6 px-10 col-span-1 place-self-start', 'title' => $pest->name ?? ''])
                    <div class='flex flex-col'>
                        <div class='flex flex-col pb-7'>
                            <div class='flex flex-row items-center mb-4'>
                                @include('components.general.image', [
                                    'class' => 'w-12 mr-4',
                                    'src' => asset(
                                        '/images/' . $pest->code . '.svg' ?? 'https://via.placeholder.com/300x200'),
                                ])
                                <h3 class='font-semibold'>{{ $pest->name ?? '' }}</h3>
                            </div>
                            <span class="text-sm font-light">{!! $pest->description ?? '' !!}
                            </span>
                        </div>
                        @include('components.general.smallatozbanner')
                    </div>
                @endcomponent
            @endif
        </div>

        {{-- Providers By Location --}}
        <section x-data="{ open: false, toggle() { this.open = !this.open } }" class='bg-pest-aliceblue px-4 py-6 mb-4 lg:px-[14.5%] lg:py-24 lg:mb-0'>
            <div @click="toggle()" class="flex items-center space-x-2 pt-4 pb-8 text-center cursor-pointer">
                <h3 class='font-semibold text-2xl text-black'>
                    Providers By Location
                </h3>

                {{-- :class="{'bg-blue-500': isActive, 'bg-red-500': !isActive}" class="w-16 h-16"></div> --}}

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" :class="{ 'animate rotate-90': open, '': !open }" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </div>
            <div x-show="open" class="grid grid-cols-1 lg:grid-cols-4 pt-4">
                @foreach ($sublocalities as $locality)
                    <a href={{ $locality['link'] }} class="text-center">
                        <p
                            className='font-semibold text-black overflow-hidden text-ellipsis whitespace-normal leading-6 line-clamp-6 mx-2 my-2'>
                            {{ $locality['item'] }}</p>
                    </a>
                @endforeach
            </div>
        </section>
    </div>

    <x-footer-controller />
@endsection

@section('scripts')
    <script>
        function initMap() {
            // Drop pins
            var locations = <?php echo json_encode($locations); ?>;

            var bounds = new google.maps.LatLngBounds();
            locations.forEach(function(location) {
                bounds.extend(location);
            });

            var map = new google.maps.Map(document.getElementById('map'), {
                center: bounds.getCenter(),
                zoom: 8
            });

            map.fitBounds(bounds);

            locations.forEach(function(location) {
                var marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    title: location.title,
                    icon: {
                        url: 'https://res.cloudinary.com/dtzokbm6x/image/upload/v1679354165/bpca-pin_bn0zus.png',
                        scaledSize: new google.maps.Size(50, 50)
                    }
                });

                // Pass in information
                var contentString = '<h2>' + location.title + '</h2>' +
                    '<p>' + location.address + '</p>' + '<p>' + location.phone + '</p>';

                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });

                marker.addListener('click', function() {
                    infowindow.open(map, marker);
                });
            });
        }
    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&callback=initMap">
    </script>
@endsection
