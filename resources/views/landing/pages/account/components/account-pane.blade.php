<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">
    
    <!-- 1. Informasi Profil -->
    <div class="lg:col-span-8">
        <div class="bg-white border border-gray-100 rounded-[2rem] sm:rounded-[2.5rem] shadow-sm overflow-hidden text-center sm:text-left">
            <div class="px-6 py-5 sm:px-8 sm:py-6 border-b border-gray-50 flex flex-col sm:flex-row items-center gap-4 bg-primary/[0.02]">
                <div class="size-10 rounded-xl bg-primary text-white flex items-center justify-center shadow-lg shadow-primary/20 shrink-0">
                    <i class="ki-filled ki-user text-xl"></i>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-black text-gray-900 tracking-tight">Informasi Profil</h3>
                    <p class="text-[9px] sm:text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Perbarui data diri dan kontak Anda</p>
                </div>
            </div>

            <form action="{{ route('account.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-10 space-y-6 sm:space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
                    <!-- Nama -->
                    <div class="flex flex-col gap-1.5 sm:gap-2">
                        <label class="text-[10px] sm:text-xs font-bold text-gray-700 uppercase tracking-widest ml-1">Nama Lengkap</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}" 
                            class="w-full px-4 py-3 sm:py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all" placeholder="Nama Lengkap">
                        @error('full_name') <span class="text-red-500 text-[10px] font-bold ml-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div class="flex flex-col gap-1.5 sm:gap-2">
                        <label class="text-[10px] sm:text-xs font-bold text-gray-700 uppercase tracking-widest ml-1">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                            class="w-full px-4 py-3 sm:py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all" placeholder="email@domain.com">
                        @error('email') <span class="text-red-500 text-[10px] font-bold ml-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- WhatsApp -->
                    <div class="flex flex-col gap-1.5 sm:gap-2">
                        <label class="text-[10px] sm:text-xs font-bold text-gray-700 uppercase tracking-widest ml-1">No. WhatsApp</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-primary transition-colors">
                                <i class="ki-filled ki-whatsapp text-xl"></i>
                            </span>
                            <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" 
                                class="w-full pl-12 pr-4 py-3 sm:py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all" placeholder="08123456789">
                        </div>
                        @error('phone_number') <span class="text-red-500 text-[10px] font-bold ml-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Foto Profil -->
                    <div class="flex flex-col gap-1.5 sm:gap-2 text-left">
                        <label class="text-[10px] sm:text-xs font-bold text-gray-700 uppercase tracking-widest ml-1">Foto Profil</label>
                        <div class="relative group cursor-pointer border border-gray-200 rounded-xl p-2 bg-gray-50 hover:bg-white transition-all">
                            <input type="file" name="photo" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewAvatar(this)">
                            <div class="flex items-center gap-3">
                                <div id="avatar-input-preview" class="size-9 rounded-lg overflow-hidden border border-gray-200 bg-white shadow-sm shrink-0">
                                    <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('assets/dashboard/images/profile/user-1.jpg') }}" class="w-full h-full object-cover">
                                </div>
                                <span class="text-[10px] sm:text-xs font-bold text-gray-500 line-clamp-1">Klik untuk ganti foto</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="flex flex-col gap-1.5 sm:gap-2 text-left">
                    <label class="text-[10px] sm:text-xs font-bold text-gray-700 uppercase tracking-widest ml-1">Alamat Lengkap</label>
                    <textarea name="address" rows="4" 
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all" placeholder="Masukkan alamat lengkap pengiriman...">{{ old('address', $user->address) }}</textarea>
                    @error('address') <span class="text-red-500 text-[10px] font-bold ml-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-center sm:justify-end pt-2">
                    <button type="submit" class="w-full sm:w-auto px-10 py-4 bg-primary text-white font-black rounded-2xl shadow-xl shadow-primary/20 hover:scale-[1.03] active:scale-95 transition-all flex items-center justify-center gap-2">
                        <span>Simpan Perubahan</span>
                        <i class="ki-filled ki-check text-xl"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. Reset Password -->
    <div class="lg:col-span-4">
        <div class="bg-white border border-gray-100 rounded-[2rem] sm:rounded-[2.5rem] shadow-sm overflow-hidden lg:sticky lg:top-[180px]">
            <div class="px-6 py-5 sm:px-8 sm:py-6 border-b border-gray-50 flex flex-col sm:flex-row items-center gap-4 bg-yellow-500/[0.02]">
                <div class="size-10 rounded-xl bg-yellow-500 text-white flex items-center justify-center shadow-lg shadow-yellow-500/20 shrink-0">
                    <i class="ki-filled ki-lock text-xl"></i>
                </div>
                <div class="text-center sm:text-left">
                    <h3 class="text-base sm:text-lg font-black text-gray-900 tracking-tight">Keamanan</h3>
                    <p class="text-[9px] sm:text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Perbarui kata sandi akun Anda</p>
                </div>
            </div>

            <form action="{{ route('account.password.update') }}" method="POST" class="p-6 sm:p-8 space-y-6">
                @csrf
                @method('PUT')

                <!-- Current Password -->
                <div class="flex flex-col gap-1.5 sm:gap-2">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Password Lama</label>
                    <div class="relative">
                        <input type="password" name="existing_password" id="existing_password"
                            class="w-full pl-4 pr-12 py-3 sm:py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold focus:bg-white transition-all" placeholder="••••••••">
                        <button type="button" class="absolute inset-y-0 right-0 pr-4 text-gray-400 hover:text-primary toggle-password" data-target="#existing_password">
                            <i class="ki-filled ki-eye text-lg"></i>
                        </button>
                    </div>
                    @error('existing_password') <span class="text-red-500 text-[10px] font-bold ml-1">{{ $message }}</span> @enderror
                </div>

                <!-- New Password -->
                <div class="flex flex-col gap-1.5 sm:gap-2">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Password Baru</label>
                    <div class="relative">
                        <input type="password" name="new_password" id="new_password"
                            class="w-full pl-4 pr-12 py-3 sm:py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold focus:bg-white transition-all" placeholder="••••••••">
                        <button type="button" class="absolute inset-y-0 right-0 pr-4 text-gray-400 hover:text-primary toggle-password" data-target="#new_password">
                            <i class="ki-filled ki-eye text-lg"></i>
                        </button>
                    </div>
                    @error('new_password') <span class="text-red-500 text-[10px] font-bold ml-1">{{ $message }}</span> @enderror
                </div>

                <!-- Confirm Password -->
                <div class="flex flex-col gap-1.5 sm:gap-2">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                            class="w-full pl-4 pr-12 py-3 sm:py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold focus:bg-white transition-all" placeholder="••••••••">
                        <button type="button" class="absolute inset-y-0 right-0 pr-4 text-gray-400 hover:text-primary toggle-password" data-target="#new_password_confirmation">
                            <i class="ki-filled ki-eye text-lg"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 bg-gray-900 text-white font-black rounded-2xl shadow-xl hover:bg-black transition-all flex items-center justify-center gap-2 active:scale-95">
                    <span>Ganti Password</span>
                    <i class="ki-filled ki-security-user text-xl"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function previewAvatar(input) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('#avatar-input-preview img').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    $(document).ready(function() {
        $('.toggle-password').on('click', function() {
            const target = $(this).data('target');
            const input = $(target);
            const icon = $(this).find('i');

            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('ki-eye').addClass('ki-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('ki-eye-slash').addClass('ki-eye');
            }
        });
    });
</script>
