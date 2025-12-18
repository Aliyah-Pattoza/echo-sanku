<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Profile Info Card -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl mb-6">
                <div class="p-8">
                    <div class="flex items-center gap-6 mb-6">
                        @if($user->profile && $user->profile->avatar)
                            <img src="{{ Storage::url($user->profile->avatar) }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover border-4 border-sanku-accent">
                        @else
                            <div class="w-24 h-24 rounded-full bg-sanku-accent flex items-center justify-center text-white text-3xl font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h3>
                            <p class="text-gray-600">{{ $user->email }}</p>
                            <span class="inline-block mt-2 px-3 py-1 bg-sanku-accent bg-opacity-20 text-sanku-dark text-sm font-semibold rounded-full">
                                Nasabah
                            </span>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('nasabah.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50" required>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->profile->phone ?? '') }}" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                                <textarea name="address" rows="3" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">{{ old('address', $user->profile->address ?? '') }}</textarea>
                                @error('address')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kota</label>
                                <input type="text" name="city" value="{{ old('city', $user->profile->city ?? '') }}" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                                @error('city')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Provinsi</label>
                                <input type="text" name="province" value="{{ old('province', $user->profile->province ?? '') }}" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                                @error('province')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Pos</label>
                                <input type="text" name="postal_code" value="{{ old('postal_code', $user->profile->postal_code ?? '') }}" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                                @error('postal_code')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Profil</label>
                                <input type="file" name="avatar" accept="image/*" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50">
                                <p class="text-sm text-gray-600 mt-1">Format: JPG, PNG (Max: 2MB)</p>
                                @error('avatar')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="px-6 py-3 bg-sanku-accent text-white rounded-lg font-bold hover:bg-sanku-primary transition">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Change Password Card -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                <div class="p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Ubah Password</h3>

                    <form method="POST" action="{{ route('nasabah.profile.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Password Saat Ini</label>
                                <input type="password" name="current_password" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50" required>
                                @error('current_password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                                <input type="password" name="password" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50" required>
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="w-full rounded-lg border-gray-300 focus:border-sanku-accent focus:ring focus:ring-sanku-accent focus:ring-opacity-50" required>
                            </div>
                        </div>

                        <button type="submit" class="mt-6 px-6 py-3 bg-sanku-secondary text-white rounded-lg font-bold hover:bg-sanku-dark transition">
                            Ubah Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>