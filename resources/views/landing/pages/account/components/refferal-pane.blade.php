<div class="space-y-6">
    <div class="flex items-center justify-between mb-2 px-1">
        <h3 class="text-xl font-black text-gray-900 tracking-tight">Member Referral Saya</h3>
        <span class="px-4 py-1.5 bg-primary/10 text-primary rounded-xl text-xs font-black uppercase tracking-widest">
            Total: {{ $referrals->total() }} Member
        </span>
    </div>

    @if($referrals->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($referrals as $ref)
                <div class="bg-white border border-gray-100 rounded-[2rem] p-6 shadow-sm hover:shadow-xl hover:border-primary/20 transition-all duration-500 group text-center flex flex-col items-center">
                    <div class="size-20 rounded-full border-4 border-gray-50 overflow-hidden mb-4 shadow-md group-hover:scale-105 transition-transform duration-500 bg-gray-100">
                        <img src="{{ $ref->photo ? asset('storage/' . $ref->photo) : asset('assets/dashboard/images/profile/user-1.jpg') }}" 
                             class="w-full h-full object-cover">
                    </div>
                    <h4 class="text-base font-bold text-gray-900 group-hover:text-primary transition-colors line-clamp-1">{{ $ref->full_name }}</h4>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1 italic">{{ $ref->affiliateLevel?->name ?? 'Member' }}</p>
                    
                    <div class="mt-4 pt-4 border-t border-gray-50 w-full">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Bergabung Pada</p>
                        <p class="text-xs font-bold text-gray-700">{{ $ref->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10 flex justify-center">
            {{ $referrals->links('landing.partials.pagination') }}
        </div>
    @else
        <div class="py-20 text-center bg-white border border-gray-100 rounded-[3rem] shadow-sm">
            <div class="size-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="ki-filled ki-people text-4xl text-gray-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Referral</h3>
            <p class="text-gray-500 font-medium max-w-sm mx-auto mb-8">Ajak rekan penulis atau pembaca lain untuk bergabung menggunakan kode referral Anda dan dapatkan komisi royalti!</p>
            
            <div class="inline-flex flex-col sm:flex-row items-center gap-4 bg-primary/5 p-6 rounded-[2rem] border border-primary/10">
                <div class="text-center sm:text-left">
                    <p class="text-[10px] font-black text-primary uppercase tracking-widest mb-1">Kode Referral Anda</p>
                    <p class="text-2xl font-black text-gray-900 tracking-widest uppercase">{{ $user->referral_code }}</p>
                </div>
                <button type="button" class="link-referral px-8 py-3.5 bg-primary text-white text-xs font-black uppercase tracking-widest rounded-xl shadow-lg shadow-primary/20 hover:scale-105 active:scale-95 transition-all flex items-center gap-2" data-referral="{{ $user->referral_code }}">
                    <i class="ki-filled ki-copy text-base"></i> Salin Link
                </button>
            </div>
        </div>
    @endif
</div>
