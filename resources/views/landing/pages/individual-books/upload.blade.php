@extends('landing.layouts.app')

@section('title', 'Upload Naskah - Daya Media')

@section('content')
<div class="bg-gray-50/50 min-h-screen pb-20 pt-10">
    <div class="kt-container-fixed">
        
        {{-- ===== BREADCRUMB ===== --}}
        <div class="flex items-center gap-2 text-sm font-medium mb-10">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary transition-colors">Beranda</a>
            <i class="ki-filled ki-right text-[10px] text-gray-400"></i>
            <a href="{{ route('member') }}" class="text-gray-500 hover:text-primary transition-colors">Akun Saya</a>
            <i class="ki-filled ki-right text-[10px] text-gray-400"></i>
            <span class="text-gray-900">Upload Naskah</span>
        </div>

        <div class="max-w-[900px] mx-auto">
            <div class="bg-white border border-gray-100 rounded-[3rem] shadow-xl shadow-gray-200/40 overflow-hidden">
                
                <!-- Header Section -->
                <div class="p-8 sm:p-12 border-b border-gray-100 bg-primary/[0.02] relative">
                    <div class="absolute top-0 right-0 size-40 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                    
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 relative z-10">
                        <div class="flex items-center gap-4">
                            <div class="size-16 rounded-[1.5rem] bg-primary text-white flex items-center justify-center shadow-xl shadow-primary/30">
                                <i class="ki-filled ki-file-up text-4xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-black text-gray-900 tracking-tight">Upload Naskah</h1>
                                <p class="text-sm font-medium text-gray-500 mt-1 uppercase tracking-widest">Transaksi: <span class="text-primary font-black">{{ $transaction->transaction_code }}</span></p>
                            </div>
                        </div>
                        <div class="px-4 py-2 bg-white border border-gray-200 rounded-xl shadow-sm">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Paket Anda</p>
                            <p class="text-sm font-bold text-gray-900 leading-none">{{ $transaction->individualBookPackage->name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Form Section -->
                <div class="p-8 sm:p-12">
                    <form action="{{ route('individual-books.upload.store', $transaction) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                        @csrf
                        
                        <!-- Section 1: Detail Buku -->
                        <div class="space-y-6">
                            <h3 class="text-sm font-black text-primary uppercase tracking-[0.3em] flex items-center gap-3">
                                <div class="w-8 h-px bg-primary/30"></div> 01. Detail Identitas Buku
                            </h3>
                            
                            <div class="grid grid-cols-1 gap-6">
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-widest ml-1">Judul Lengkap Naskah <span class="text-red-500">*</span></label>
                                    <input type="text" name="title" value="{{ old('title', $book->title ?? '') }}" required
                                        class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-bold text-gray-900 focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all" placeholder="Masukkan judul buku Anda...">
                                    @error('title')
                                        <p class="text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-widest ml-1">Kategori Buku <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <select name="category_id" required class="w-full px-5 py-4 pr-12 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-bold text-gray-900 focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all appearance-none cursor-pointer">
                                            <option value="">Pilih Kategori...</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ old('category_id', $book->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                        <i class="ki-filled ki-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                    </div>
                                    @error('category_id')
                                        <p class="text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-widest ml-1">Abstrak / Deskripsi Singkat <span class="text-red-500">*</span></label>
                                    <textarea name="description" rows="5" required
                                        class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-medium text-gray-900 focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all" placeholder="Tuliskan ringkasan isi buku Anda di sini...">{{ old('description', $book->description ?? '') }}</textarea>
                                    @error('description')
                                        <p class="text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Penulis Buku -->
                        <div class="space-y-6">
                            @php
                                $maxDefaultAuthors = $transaction->individualBookPackage->max_authors_default ?? 3;
                                $extraAuthors = $transaction->additional_authors_count ?? 0;
                                $totalAuthors = $maxDefaultAuthors + $extraAuthors;
                            @endphp

                            <h3 class="text-sm font-black text-primary uppercase tracking-[0.3em] flex items-center gap-3">
                                <div class="w-8 h-px bg-primary/30"></div> 02. Penulis Buku
                            </h3>
                            <p class="text-xs font-medium text-gray-500 -mt-2 ml-11">
                                Paket ini mencakup {{ $maxDefaultAuthors }} penulis bawaan.
                                @if($extraAuthors > 0)
                                    Anda memesan {{ $extraAuthors }} penulis tambahan, total {{ $totalAuthors }} slot penulis.
                                @endif
                            </p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex flex-col gap-2">
                                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Penulis 1 (Utama)</label>
                                    <input type="text" value="{{ auth()->user()->full_name }}"
                                        class="w-full px-4 py-3.5 bg-gray-100 border border-gray-200 rounded-xl text-sm font-bold text-gray-500" readonly>
                                </div>

                                @for($i = 2; $i <= $totalAuthors; $i++)
                                    <div class="flex flex-col gap-2">
                                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Penulis {{ $i }}</label>
                                        <input type="text" name="additional_authors[]" value="{{ old('additional_authors.'.($i - 2), $authors[$i - 2]['author'] ?? '') }}"
                                            class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-900 focus:bg-white transition-all" placeholder="Nama lengkap penulis {{ $i }}">
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <!-- Section 3: File Upload -->
                        <div class="space-y-6">
                            <h3 class="text-sm font-black text-primary uppercase tracking-[0.3em] flex items-center gap-3">
                                <div class="w-8 h-px bg-primary/30"></div> 03. Upload File Naskah
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Full Content -->
                                <div class="space-y-3">
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-widest ml-1 flex justify-between">
                                        Naskah Lengkap <span class="text-red-500 text-[10px] normal-case font-medium">(PDF/DOCX)</span>
                                    </label>
                                    <div class="relative group cursor-pointer border-2 border-dashed border-gray-200 rounded-3xl p-8 text-center hover:border-primary/50 hover:bg-primary/[0.02] transition-all duration-300">
                                        <input type="file" name="full_content" class="absolute inset-0 opacity-0 cursor-pointer z-10 file-input" accept=".pdf,.doc,.docx" {{ isset($modules->file_path) ? '' : 'required' }}>
                                        <div class="space-y-3 placeholder-view">
                                            <i class="ki-filled ki-document text-4xl text-gray-300 group-hover:text-primary transition-colors"></i>
                                            <p class="text-sm font-bold text-gray-700">Pilih File Naskah</p>
                                        </div>
                                        <div class="hidden preview-view space-y-2">
                                            <i class="ki-filled ki-file-added text-4xl text-green-500"></i>
                                            <p class="text-xs font-black text-green-600 truncate px-4 file-name-display"></p>
                                        </div>
                                    </div>
                                    @error('full_content')
                                        <p class="text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                    @enderror
                                    @if(isset($modules->file_path))
                                        <p class="text-[10px] text-green-600 font-bold ml-1 flex items-center gap-1"><i class="ki-filled ki-check-circle"></i> File naskah sudah terupload</p>
                                    @endif
                                </div>

                                <!-- Turnitin -->
                                <div class="space-y-3">
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-widest ml-1 flex justify-between">
                                        Hasil Turnitin <span class="text-gray-400 text-[10px] normal-case font-medium">(Opsional)</span>
                                    </label>
                                    <div class="relative group cursor-pointer border-2 border-dashed border-gray-200 rounded-3xl p-8 text-center hover:border-primary/50 hover:bg-primary/[0.02] transition-all duration-300">
                                        <input type="file" name="turnitin_file" class="absolute inset-0 opacity-0 cursor-pointer z-10 file-input" accept=".pdf">
                                        <div class="space-y-3 placeholder-view">
                                            <i class="ki-filled ki-shield-search text-4xl text-gray-300 group-hover:text-primary transition-colors"></i>
                                            <p class="text-sm font-bold text-gray-700">Laporan Turnitin</p>
                                        </div>
                                        <div class="hidden preview-view space-y-2">
                                            <i class="ki-filled ki-file-added text-4xl text-green-500"></i>
                                            <p class="text-xs font-black text-green-600 truncate px-4 file-name-display"></p>
                                        </div>
                                    </div>
                                    @error('turnitin_file')
                                        <p class="text-xs font-bold text-red-500 ml-1">{{ $message }}</p>
                                    @enderror
                                    @if(isset($modules->file_path_turnitin))
                                        <p class="text-[10px] text-green-600 font-bold ml-1 flex items-center gap-1"><i class="ki-filled ki-check-circle"></i> File turnitin sudah terupload</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="pt-10 border-t border-gray-100 flex flex-col sm:flex-row items-center gap-4">
                            <button type="submit" class="w-full sm:w-auto px-10 py-5 bg-primary text-white font-black rounded-2xl shadow-2xl shadow-primary/30 hover:scale-105 active:scale-95 transition-all flex items-center justify-center gap-3 text-lg group">
                                <span>Simpan & Ajukan Editorial</span>
                                <i class="ki-filled ki-send text-2xl group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                            </button>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest text-center sm:text-left">Pastikan semua data sudah benar sebelum mengirimkan naskah Anda.</p>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('.file-input').on('change', function() {
            const container = $(this).parent();
            const file = this.files[0];
            if (file) {
                container.find('.placeholder-view').addClass('hidden');
                container.find('.preview-view').removeClass('hidden');
                container.find('.file-name-display').text(file.name);
                container.addClass('border-green-300 bg-green-50/30');
            }
        });
    });
</script>
@endpush
