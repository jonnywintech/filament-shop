<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="flex h-full items-center">
        <main class="w-full max-w-md mx-auto p-6">
            <div class="mt-7 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="p-4 sm:p-7">
                    <div class="text-center">
                        <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Forgot password?</h1>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Remember your password?
                            <a class="text-blue-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                href="/login">
                                Sign in here
                            </a>
                        </p>
                    </div>

                    <div class="mt-5">
                        <!-- Form -->
                        <form wire:submit.prevent="forgotPassword">
                            <div class="grid gap-y-4">
                                <!-- Form Group -->
                                @error('email')
                                    <div class="mt-2 bg-yellow-500 text-sm text-white rounded-lg p-4" role="alert"
                                        tabindex="-1" aria-labelledby="hs-solid-color-warning-label">
                                        <span id="hs-solid-color-warning-label" class="font-bold">
                                            {{ $message }}
                                    </div>
                                @enderror
                                @if (session('success'))
                                    <div class="mt-2 bg-teal-500 text-sm text-white rounded-lg p-4" role="alert"
                                        tabindex="-1" aria-labelledby="hs-solid-color-success-label">
                                        <span id="hs-solid-color-success-label"
                                            class="font-bold">Successfully sent</span> {{ session('success') }}
                                    </div>
                                @endif
                                <div>
                                    <label for="email" class="block text-sm mb-2 dark:text-white">Email
                                        address</label>
                                    <div class="relative">
                                        <input type="email" id="email" wire:model="email"
                                            class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                            aria-describedby="email-error">
                                    </div>
                                </div>
                                <!-- End Form Group -->
                                <button type="submit"
                                    class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">Reset
                                    password</button>
                            </div>
                        </form>
                        <!-- End Form -->
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
