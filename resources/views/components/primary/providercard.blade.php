<div class="flex flex-col w-full h-full bg-white rounded-md border">
    <div
        class="flex h-full
                flex-row sm:flex-row md:flex-col-reverse lg:flex-col-reverse
                justify-between p-4">
        <div
            class="basis-3/4 lg:basis-1 md:basis-1 sm:basis-3/4
                    flex flex-col 
                    items-start lg:items-center md:items-center sm:items-start
                    justify-center">
            <h2
                class="text-xs font-semibold
                        text-left lg:text-center md:text-center sm:text-left
                        leading-5">
                {{ $name ?? '' }}
            </h2>
            <p
                class="text-xs text-gray-400
                        text-left lg:text-center md:text-center sm:text-left
                        leading-5">
                {{ $address ?? '' }}
            </p>
        </div>
        <div
            class="basis-1/4 lg:basis-1 md:basis-1 sm:basis-1/4
                    flex flex-col 
                    items-end lg:items-center md:items-center sm:items-end
                    pb-0 lg:pb-2 md:pb-2 sm:pb-0
                    justify-center">
            <img src={{ $src }} alt={{ $name ?? '' }} class="w-28 h-auto overflow-hidden" />
        </div>
    </div>
    {{-- {accredited && (
                <p class='text-pest-rose text-center text-xs mb-2'>ACCREDITED SINCE {accredited}</p>
            )} --}}
    {{-- {features && (
                <div class='text-center mb-4'>
                    {features.map((feature, index) => (
                        <p
                            key={index}
                            class='text-[0.65rem] bg-pest-badge-lightpink rounded-xl inline-block m-1 py-1 px-2'
                        >
                            {feature}
                        </p>
                    ))}
                </div>
            )} --}}
    <div class="flex flex-row items-center justify-center border-t">
        <a href="/details/{{ $slug }}/{{ $external_id }}"
            class="w-full hover:cursor-pointer mx-auto my-auto h-10 rounded-l-md font-medium border-r text-gray-700 text-xs items-center flex justify-center">

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="h-4.5 w-4 mr-2 mb-0.5 text-pest-icon-purple">
                <path fill-rule="evenodd"
                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                    clip-rule="evenodd" />
            </svg>

            Details
        </a>
        <a href="tel:{{ $phone ?? '#' }}"
            class="w-full hover:cursor-pointer mx-auto my-auto h-10 rounded-md font-medium text-gray-700 text-xs items-center flex justify-center">

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                class="h-4 w-4 mr-2 mb-0.5 text-pest-icon-purple">
                <path fill-rule="evenodd"
                    d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z"
                    clip-rule="evenodd" />
            </svg>

            Call
        </a>
    </div>
</div>
