<div class="space-y-6">
    <div class="flex items-center justify-between mb-2 px-1">
        <h3 class="text-xl font-black text-gray-900 tracking-tight">Dokumen Saya</h3>
        <span class="px-4 py-1.5 bg-primary/10 text-primary rounded-xl text-xs font-black uppercase tracking-widest">
            Total: {{ $documents->total() }} File
        </span>
    </div>

    @if($documents->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($documents as $doc)
                <div class="bg-white border border-gray-100 rounded-[2rem] p-6 shadow-sm hover:shadow-xl hover:border-primary/20 transition-all duration-300 group flex items-center gap-5">
                    <!-- Icon -->
                    <div class="size-16 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-primary group-hover:text-white transition-all shadow-inner shrink-0">
                        <i class="ki-filled ki-files text-3xl"></i>
                    </div>

                    <!-- Info -->
                    <div class="flex flex-col grow min-w-0">
                        <h4 class="text-sm font-bold text-gray-900 line-clamp-1 group-hover:text-primary transition-colors">{{ $doc->name }}</h4>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Ukuran: {{ number_format($doc->size / 1024, 2) }} KB</p>
                        
                        <div class="mt-4">
                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-primary hover:text-primary-dark transition-colors">
                                <i class="ki-filled ki-download text-base"></i> Unduh Dokumen
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10 flex justify-center">
            {{ $documents->links() }}
        </div>
    @else
        <div class="py-20 text-center bg-white border border-gray-100 rounded-[3rem] shadow-sm">
            <div class="size-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                <i class="ki-filled ki-files text-4xl"></i>
            </div>
            <h4 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Dokumen</h4>
            <p class="text-gray-500 font-medium max-w-sm mx-auto">Dokumen penting terkait kerjasama atau naskah Anda akan muncul di sini.</p>
        </div>
    @endif
</div>
