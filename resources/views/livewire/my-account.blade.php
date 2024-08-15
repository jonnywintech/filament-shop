<div class="container">
    <div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
       <!-- Notifications -->
        <div class="fixed bottom-0 right-0 z-50 p-6 space-y-4" x-data="{ notifications: @entangle('notifications') }">
            <template x-for="notification in notifications" :key="notification.id">
                <div class="p-4 bg-white border rounded-xl shadow-sm"
                     :class="{ 'border-green-200': notification.type === 'success', 'border-red-200': notification.type === 'error' }"
                     x-show="true"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-90">
                    <div class="flex items-center space-x-3">
                        <div class="flex-1">
                            <p class="text-sm font-medium"
                               :class="{ 'text-green-800': notification.type === 'success', 'text-red-800': notification.type === 'error' }"
                               x-text="notification.message"></p>
                        </div>
                        <button @click="$wire.removeNotification(notification.id)" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </template>
        </div>
        <!-- Profile Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-800">Profile</h2>
            <p class="text-gray-600 mt-2">Manage your name, password, and account settings.</p>

            <div class="items-center space-x-6 mt-6 flex flex-col md:flex-row ">

                <span class=" rounded-full border p-7 ">
                    <svg class="ylm2u sj82x" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>
                        <circle cx="9" cy="9" r="2"></circle>
                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                    </svg>
                </span>
                <div>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Upload Photo</button>
                    <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 mt-2">Delete</button>
                    <p class="text-gray-500 mt-2">Pick a photo up to 1MB.</p>
                </div>
            </div>
        </div>

        <!-- Personal Info Section -->
        <hr class="py-2">

        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-800">Personal Info</h2>
            <p class="text-gray-600 mt-2">Enter your personal information.</p>

            <form class="space-y-6 mt-6" wire:submit.prevent="updateInfo">
                @csrf
                <div>
                    <label class="block text-gray-700">Name</label>
                    <input type="text" placeholder="Enter your full name" wire:model="name"
                        class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-gray-500 mt-1">Enter your full name, or a display name you are comfortable with.</p>
                    @error('name')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700">Email</label>
                    <input type="email" placeholder="Enter email address" wire:model="email"
                        class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-gray-500 mt-1">Enter the email address you want to use to log in.</p>
                    @error('email')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-start space-x-4 mt-6">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Save
                        Changes</button>
                    <button type="button"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400">Cancel</button>
                </div>
            </form>
        </div>

        <!-- Password Section -->
        <hr class="py-2">

        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Password</h2>
            <p class="text-gray-600 mt-2">Change your password.</p>

            <form class="space-y-6 mt-6" wire:submit.prevent="updatePassword">
                @csrf
                <div class="relative" x-data="{ oldPassword: true }">
                    <label class="block text-gray-700 relative">Current Password</label>
                    <input type="password" placeholder="Enter current password" wire:model="old_password"
                        :type="oldPassword ? 'password' : 'text'"
                        class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                    <div class="absolute inset-y-12 right-0 pr-3 flex items-center text-sm leading-5">
                        <!-- Toggle eye icon for Current Password -->
                        <svg class="h-6" :class="{ 'hidden': !oldPassword, 'block': oldPassword }"
                            @click="oldPassword = !oldPassword" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <svg class="h-6" :class="{ 'hidden': oldPassword, 'block': !oldPassword }"
                            @click="oldPassword = !oldPassword" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </div>
                    @error('old_password')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="relative" x-data="{ newPassword: true }" x-init="$watch('newPassword', value => repeatNewPassword = value)">
                    <label class="block text-gray-700">New Password</label>
                    <input type="password" placeholder="Enter new password" :type="newPassword ? 'password' : 'text'"
                        wire:model="new_password"
                        class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                    <div class="absolute inset-y-12 right-0 pr-3 flex items-center text-sm leading-5">
                        <!-- Toggle eye icon for New Password -->
                        <svg class="h-6" :class="{ 'hidden': !newPassword, 'block': newPassword }"
                            @click="newPassword = !newPassword" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <svg class="h-6" :class="{ 'hidden': newPassword, 'block': !newPassword }"
                            @click="newPassword = !newPassword" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </div>
                    @error('new_password')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="relative" x-data="{ repeatNewPassword: true }">
                    <label class="block text-gray-700">Repeat New Password</label>
                    <input type="password" placeholder="Repeat new password" wire:model="new_password_confirm"
                        :type="repeatNewPassword ? 'password' : 'text'"
                        class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                    <div class="absolute inset-y-12 right-0 pr-3 flex items-center text-sm leading-5">
                        <!-- Toggle eye icon for Repeat New Password -->
                        <svg class="h-6" :class="{ 'hidden': !repeatNewPassword, 'block': repeatNewPassword }"
                            @click="repeatNewPassword = !repeatNewPassword" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <svg class="h-6" :class="{ 'hidden': repeatNewPassword, 'block': !repeatNewPassword }"
                            @click="repeatNewPassword = !repeatNewPassword" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </div>
                    @error('new_password_confirm')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-between items-center mt-6">
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Change</button>
                    <a href="#" class="text-blue-500 hover:underline">I forgot my password</a>
                </div>
            </form>
        </div>

    </div>
</div>
