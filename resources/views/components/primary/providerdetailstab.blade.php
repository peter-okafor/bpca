<div x-data="{ activeTab: 'tab1' }"
    class="w-full rounded-md bg-white pb-10 pt-2 -mt-80 col-span-1 lg:col-span-2 md:col-span-2 sm:col-span-1">
    {{-- Tab header --}}
    <ul class='flex flex-row border-b border-gray-300 px-10'>
        {{-- <li @click.prevent="activeTab = 'tab1'" :class="{ 'border-[#F62F56] text-gray-800': activeTab === 'tab1' }"
            class="border-transparent text-gray-300 border-b-2 font-medium mr-6 cursor-pointer py-3 text-sm">
            <a href='#'>
                Profile
            </a>
        </li>

        <li @click.prevent="activeTab = 'tab2'" :class="{ 'border-[#F62F56] text-gray-800': activeTab === 'tab2' }"
            class="border-transparent text-gray-300 border-b-2 font-medium mr-6 cursor-pointer py-3 text-sm">
            <a href='#'>
                Services
            </a>
        </li> --}}

        <li @click.prevent="activeTab = 'tab1'"
            :class="{ 'border-[#F62F56] text-gray-800': activeTab === 'tab1', 'border-transparent text-gray-300': activeTab !==
                    'tab1' }"
            class="border-b-2 font-medium mr-6 cursor-pointer py-3 text-sm">
            <a href='#'>
                Profile
            </a>
        </li>

        <li @click.prevent="activeTab = 'tab2'"
            :class="{ 'border-[#F62F56] text-gray-800': activeTab === 'tab2', 'border-transparent text-gray-300': activeTab !==
                    'tab2' }"
            class="border-b-2 font-medium mr-6 cursor-pointer py-3 text-sm">
            <a href='#'>
                Services
            </a>
        </li>
    </ul>

    <div class='w-full px-10'>
        <div class="block w-full">
            {{-- Profile --}}
            <div x-show="activeTab === 'tab1'">
                @if ($provider->description)
                    @include('components.general.labelledtext', [
                        'label' => 'About',
                        'content' => $provider->description ?? '',
                    ])
                @endif

                @if ($provider->town || $provider->postcode)
                    @include('components.general.labelledtext', [
                        'label' => 'Address',
                        'content' => $provider->town
                            ? $provider->town . ', ' . $provider->postcode
                            : $provider->postcode,
                    ])
                @endif

                @if ($provider->contact_hours)
                    @include('components.general.labelledtext', [
                        'label' => 'Opening Hours',
                        'content' => $provider->contact_hours,
                    ])
                @endif

                @if ($provider->premises_type)
                    @include('components.general.labelledtext', [
                        'label' => 'Premises Type',
                        'content' => $provider->premises_type,
                    ])
                @endif
            </div>

            <div x-show="activeTab === 'tab2'">
                <div class='grid grid-cols-1 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1'>
                    @foreach ($provider->pests as $pest)
                        <a href="/pests/{{ $pest->name }}">
                            <div class="w-full flex flex-row mt-6">
                                @include('components.general.image', [
                                    'src' => asset('/images/' . $pest->code . '.svg' ?? ''),
                                    'class' => 'w-12 h-auto',
                                    'alt' => $pest->name ?? '',
                                ])
                                <p class="py-5 text-sm px-4 py-4 px-3">{{ $pest->name ?? '' }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <a href="/pests"
                    class="bg-atoz bg-no-repeat mt-28 bg-center bg-cover bg-origin-border rounded-lg w-full h-16 text-center text-white overflow-hidden py-auto cursor-pointer">
                    <p class='pt-4 font-black text-3xl h-full'>
                        <span class='inline'>A</span>
                        <span class='inline'>-</span>
                        <span class='inline pr-1.5'>Z</span>
                        <span class='inline text-2xl'>of Pests</span>
                    </p>
                </a>
            </div>
        </div>
    </div>
</div>
