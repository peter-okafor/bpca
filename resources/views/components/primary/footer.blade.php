<footer class='bg-pest-cyprus px-4 py-16 lg:py-24 lg:px-[14.5%] flex items-center justify-between'>
    <div class="w-full">
    @include('components.general.pestlogo2', ['style' => 'h-12 w-auto mb-12 hidden lg:block'])
    <div class='grid gap-y-2 w-full grid-cols-2 gap-10 lg:grid-cols-4 lg:gap-x-10'>
        @foreach ($footers as $footer)
            <a class="text-white opacity-100 mx-2 my- font-light" href="{{ $footer->link ?? '' }}">{{ $footer->item ?? '' }}</a>
        @endforeach
    </div>
    </div>

    <div class='w-full text-right flex flex-row justify-end align-middle'>
    <img class='h-auto w-32 rounded-full my-auto mr-2' src={{  asset('/images/powered_by_bpca.png') }} alt='logo' />
</div>

</footer>


