<div>
    <!-- Title -->
    <div class="max-w-2xl text-center mx-auto pt-10 lg:mb-14">
        <h2 class="text-2xl font-bold md:text-4xl md:leading-tight dark:text-white">Read our latest news</h2>
        <p class="mt-1 text-gray-600 dark:text-neutral-400">We've helped some great companies brand, design and get to
            market.</p>
    </div>
    <!-- End Title -->
    <!-- Card Blog -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Grid -->
        <div class="grid sm:grid-cols-2 sm:items-center gap-8">
            <div class="sm:order-2">
                <div class="relative pt-[50%] sm:pt-[100%] rounded-lg">
                    <img class="size-full absolute top-0 start-0 object-cover rounded-lg"
                        src="{{ url('storage') . '/' . $posts[0]->cover_image }}" alt="Blog Image">
                </div>
            </div>
            <!-- End Col -->

            <div class="sm:order-1">
                <p
                    class="mb-5 inline-flex items-center gap-1.5 py-1.5 px-3 rounded-md text-xs font-medium bg-gray-100 text-gray-800 dark:bg-neutral-800 dark:text-neutral-200">
                    Business insight
                </p>

                <h2
                    class="text-2xl font-bold md:text-3xl lg:text-4xl lg:leading-tight xl:text-5xl xl:leading-tight text-gray-800 dark:text-neutral-200">
                    <a class="hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:text-neutral-300 dark:hover:text-white dark:focus:text-white"
                        href="#">
                        {!! $posts[0]->title !!}
                    </a>
                </h2>

                <!-- Avatar -->
                <div class="mt-6 sm:mt-10 flex items-center">
                    <div class="shrink-0">
                        <img class="size-10 sm:h-14 sm:w-14 rounded-full"
                            src="https://images.unsplash.com/photo-1669837401587-f9a4cfe3126e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=320&h=320&q=80"
                            alt="Blog Image">
                    </div>

                    <div class="ms-3 sm:ms-4">
                        <p class="sm:mb-1 font-semibold text-gray-800 dark:text-neutral-200">
                            Louise Donadieu
                        </p>
                        <p class="text-xs text-gray-500 dark:text-neutral-500">
                            {!! $posts[0]->content !!}
                        </p>
                    </div>
                </div>
                <!-- End Avatar -->

                <div class="mt-5">
                    <a class="inline-flex items-center gap-x-1.5 text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium dark:text-blue-500"
                        href="#">
                        Read more
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </a>
                </div>
            </div>
            <!-- End Col -->
        </div>
        <!-- End Grid -->
    </div>
    <!-- End Card Blog -->
    <!-- Card Blog -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Title -->
        <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
            <h2 class="text-2xl font-bold md:text-4xl md:leading-tight dark:text-white">Insights</h2>
            <p class="mt-1 text-gray-600 dark:text-neutral-400">Stay in the know with insights from industry experts.
            </p>
        </div>
        <!-- End Title -->

        <!-- Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card -->
            @foreach ($posts as $post)
                <a wire:key="{{ $post->id }}" wire:navigate
                    class="group relative flex flex-col w-full min-h-60 bg-[url('{{ url('storage') . '/' . $post->cover_image }}')] bg-center bg-cover rounded-xl hover:shadow-lg focus:outline-none focus:shadow-lg transition"
                    href="/blog/{{ $post->slug }}">
                    <div class="flex-auto p-4 md:p-6">
                        <h3 class="text-xl text-white/90 group-hover:text-white"><span
                                class="font-bold">{{ $post->title }}</span>
                            {!! Str::words($post->content, 20, '...') !!}</h3>
                    </div>
                    <div class="pt-0 p-4 md:p-6">
                        <div
                            class="inline-flex items-center gap-2 text-sm font-medium text-white group-hover:text-white/70 group-focus:text-white/70">
                            Visit the site
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
            <!-- End Card -->
        </div>
        <!-- End Grid -->
    </div>
    <!-- End Card Blog -->

</div>
