@unless ($breadcrumbs->isEmpty())
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && !$loop->last)
                    <li>
                        <a href="{{ $breadcrumb->url }}"
                            class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                            {{ $breadcrumb->title }}
                        </a>
                    </li>
                @else
                    <li>
                        <div class="flex items-center">
                            <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">
                                {{ $breadcrumb->title }}</span>
                        </div>

                    </li>
                @endif

                @unless ($loop->last)
                    <li class="text-gray-500 px-2">
                        /
                    </li>
                @endif
                @endforeach
            </ol>
        </nav>
    @endunless
