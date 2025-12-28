<div class="rounded-md bg-white w-full border pb-10 -mt-80 self-start {{ $class ?? '' }}">
    {{-- Navigation  --}}
    <div
        class='flex justify-between w-full bg-white rounded-t-md border-gray-300 h-11 align-middle text-center px-4 py-4 border-b'>
        <a href="#" onclick="window.history.back()" class="align-middle text-center text-black text-xs">&#60; &nbsp; Back</a>
        {{-- <a href="#" class="align-middle text-center text-black text-xs"> Next &nbsp; &#62;</a> --}}
    </div>

    <div class='flex flex-col justify-center align-middle text-center'>
        <div class='flex flex-row justify-center my-8'>
            @include('components.general.image', [
                'src' => asset('/images/BPCA-member-logo-400-400.png'),
                'class' => 'w-1/2',
                'alt' => $provider->name ?? '',
            ])
        </div>
        <h3 class='mb-4 px-10 font-bold'>{{ $provider->name ?? '' }}</h3>
    </div>

    {{-- Buttons --}}
    <div class='px-10 space-y-2'>
        @include('components.general.btn_details', [
            'link' => 'mailto:' . $provider->email ?? '',
            'class' => '',
            'title' => 'Email',
            'icon' => view('components.icons.email', ['class' => 'w-4 w-4 mb-0.5 text-pest-purple'])->render(),
        ])

        @include('components.general.btn_details', [
            'link' => 'tel:' . $provider->telephone ?? '',
            'class' => '',
            'title' => 'Call',
            'icon' => view('components.icons.phone', ['class' => 'w-4 w-4 mb-0.5 text-pest-purple'])->render(),
        ])

        @include('components.general.btn_details', [
            'link' => '/' . $provider->website ?? '',
            'class' => '',
            'title' => 'Website',
            'icon' => view('components.icons.web', ['class' => 'w-4 w-4 mb-0.5 text-pest-purple'])->render(),
        ])

        @include('components.general.btn_details', [
            'link' => 'https://www.google.com/maps/search/?api=1&query='.$provider->postcode ?? '',
            'class' => '',
            'target' => '_blank',
            'title' => 'Location Map',
            'icon' => view('components.icons.map_pin', ['class' => 'w-4 w-4 mb-0.5 text-pest-purple'])->render(),
        ])

        {{-- Organisation has accreditation_year --}}
        @if ($provider->accreditation_year ?? '')
            <div class="rounded-md bg-pest-aliceblue flex flex-row w-full py-7 px-9 mt-8">
                @include('components.general.image', [
                    'src' => asset('/images/BPCA-member-logo-400-400.png'),
                    'class' => 'w-20',
                    'alt' => $provider->name ?? '',
                ])
                <h4 class="font-semibold text-xl px-[15px] text-[#F62F56]">ACCREDITED MEMBER SINCE
                    {{ $provider->accreditation_year ?? ' ' }} </h4>
            </div>
        @endif

        {{-- If features exist --}}
        @if ($provider->features ?? '')
            <div class='text-center mb-4'>
                @foreach ($provider->features as $feature)
                    <p class='text-[0.65rem] bg-pest-badge-lightpink rounded-xl inline-block m-1 py-1 px-2'>
                        {{ $feature }}
                    </p>
                @endforeach
            </div>
        @endif
    </div>
</div>
