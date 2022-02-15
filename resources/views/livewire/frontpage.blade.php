<div class="divide-y divide-gray-800" x-data="{show:false}">
    <nav class="flex items-center bg-gray-900 px-3 py-2 shadow-lg">
        <div class="">
            <button @click="show===true ? show=false : show=true"
                class="block h-8 mr-3 text-gray-400 item-center hover:text-gray-200 focus:text-gray-200 focus:outline-none
             sm:hidden">
                <svg class="w-8 fill-current" viewBox="0 0 24 24">
                    {{-- <path fill-rule="evenodd" d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"/> --}}
                    <path x-show="!show" fill-rule="evenodd"
                        d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z" />
                    <path x-show="show" fill-rule="evenodd"
                        d="M18.278 16.864a1 1 0 0 1-1.414 1.414l-4.829-4.828-4.828 4.828a1 1 0 0 1-1.414-1.414l4.828-4.829-4.828-4.828a1 1 0 0 1 1.414-1.414l4.829 4.828 4.828-4.828a1 1 0 1 1 1.414 1.414l-4.828 4.829 4.828 4.828z" />
                </svg>
            </button>
        </div>
        <div class="h-12 w-full flex item-center">
            <a href="{{ url('/') }}" class="w-full">
                <x-jet-application-mark class="block h-9 w-auto" />
            </a>
        </div>
        <div class="flex justify-end sm:w-8/12">
            {{-- Top Nav Links --}}

            <ul class="hidden sm:flex sm:text-left text-gray-200 text-xs">
                @foreach ($topNavLinks as $item)
                    <a href="{{ url('/' . $item->slug) }}">
                        <li class="cursor-pointer px-4 py-2 hover:bg-gray-800">{{ $item->label }}</li>
                    </a>
                @endforeach
                {{-- <a href="{{ url('/login') }}">
                    <li class="cursor-pointer px-4 py-2 hover:underline">Login</li>
                </a> --}}
            </ul>
        </div>
    </nav>
    <div class="sm:flex sm:min-h-screen">
        <aside
            class="bg-gray-900 text-gray-700 divide-y divide-gray-600
        divide-dashed sm:w-3/12 md:w-3/12 lg:2/12 xl:1/12 ">
            {{-- Desktop Web View --}}

            <ul class=" hidden text-gray-200 text-xs sm:block sm:text-left">
                @foreach ($sideBarLinks as $item)

                    <a href="{{ url('/' . $item->slug) }}">
                        <li class="cursor-pointer px-4 py-2 hover:bg-gray-800">{{ $item->label }}</li>
                    </a>

                @endforeach

            </ul>
            {{-- Mobile Web View --}}
            <div :class="show ?'black':'hidden'" class="pb-3 divide-y divide-gray-800 block sm:hidden">
                <ul class="text-gray-200 text-xs">
                    @foreach ($sideBarLinks as $item)
                        <a href="{{ url('/' . $item->slug) }}">
                            <li class="cursor-pointer px-4 py-2 hover:bg-gray-800">{{ $item->label }}</li>
                        </a>
                    @endforeach
                </ul>
                {{-- Top Navigation Mobile Web View --}}
                <ul class="text-gray-200 text-xs">
                    @foreach ($topNavLinks as $item)
                        <a href="{{ url('/' . $item->slug) }}">
                            <li class="cursor-pointer px-4 py-2 hover:bg-gray-800">{{ $item->label }}</li>
                        </a>
                    @endforeach

                    {{-- <a href="{{ url('/login') }}">
                        <li class="cursor-pointer px-4 py-2 hover:bg-gray-800">Login</li>
                    </a> --}}
                </ul>
            </div>

        </aside>
        <main class="bg-gray-100 p-12 main-h-screen sm:w-8/12 md:w-9/12 lg:10/12">
            <section class="divide-y text-gray-900">
                <h1 class="text-3xl font-bold">
                    {{ ucwords($title) }}
                </h1>
                <article>
                    <div class="mt-5 text-sm">
                        {!! $content !!}
                    </div>
                </article>
            </section>
        </main>
    </div>
</div>
