<a class="w-full flex items-center font-light space-x-1.5 mx-auto text-xs border hover:shadow my-auto py-2 rounded-md flex flex-row justify-center ${{ $class ?? '' }}"
    href={{ $link ?? '' }} target="{{ $target ?? '' }}" rel="noreferrer">
    {!! $icon !!} <span>{{ $title }}</span>
</a>
