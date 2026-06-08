<div class="space-y-6">
    <div class="flex items-center justify-between mb-2 px-1">
        <h3 class="text-xl font-black text-gray-900 tracking-tight">Proyek Kolaborasi Saya</h3>
        <span class="px-4 py-1.5 bg-primary/10 text-primary rounded-xl text-xs font-black uppercase tracking-widest">
            Total: {{ $collaborators->total() }} Proyek
        </span>
    </div>

    @if($collaborators->count() > 0)
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 items-start">
            @foreach($collaborators as $module)
                @php
                    $book = $module->book;
                @endphp

                @if($book)
                    @php
                        $isUploadOpen = ($module->deadline == null || $module->deadline > $now) && $book->status != "published";
                    @endphp

                    <div class="relative w-full max-w-[720px] overflow-hidden rounded-[2rem] border border-gray-100 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        {{-- Badge Bab --}}
                        <div class="absolute left-5 top-5 z-20 rounded-full bg-yellow-400 px-4 py-1.5 text-[10px] font-black uppercase tracking-widest text-yellow-950 shadow-sm">
                            Bab {{ $module->chapter }}
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-[190px_1fr]">
                            {{-- Cover & Info --}}
                            <div class="relative bg-gradient-to-br from-primary/10 via-white to-gray-50 p-6 pt-12">
                                <div class="mx-auto w-32 overflow-hidden rounded-2xl border border-white bg-white shadow-lg md:mx-0">
                                    @if($book->cover)
                                        <img
                                            src="{{ asset('storage/' . $book->cover) }}"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                            class="h-44 w-full object-cover transition-transform duration-500 hover:scale-105"
                                            alt="{{ $book->title }}"
                                        >

                                        <div class="hidden h-44 w-full items-center justify-center bg-gray-200 px-4 text-center text-sm font-black text-gray-400">
                                            No Cover
                                        </div>
                                    @else
                                        <div class="flex h-44 w-full items-center justify-center bg-gray-200 px-4 text-center text-sm font-black text-gray-400">
                                            No Cover
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-5 text-center md:text-left">
                                    <span class="inline-flex rounded-full bg-primary/10 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-primary">
                                        {{ $book->category?->name ?? 'Kolaborasi' }}
                                    </span>

                                    <h4 class="mt-3 text-lg font-black leading-tight text-gray-900 line-clamp-2">
                                        {{ $book->title }}
                                    </h4>

                                    <p class="mt-2 flex items-start justify-center gap-1.5 text-xs font-bold text-gray-500 md:justify-start">
                                        <i class="ki-filled ki-users mt-0.5 text-base"></i>
                                        <span>
                                            Kontribusi Bab: {{ $module->title }}
                                        </span>
                                    </p>

                                    @if($module->deadline)
                                        <p class="mt-3 inline-flex items-center gap-1.5 rounded-full bg-white px-3 py-1.5 text-[10px] font-black uppercase tracking-widest text-gray-500 shadow-sm">
                                            <i class="ki-filled ki-calendar text-sm"></i>
                                            Deadline Tersedia
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- Upload Area --}}
                            <div class="p-5 md:p-6">
                                <div class="space-y-4">
                                    <a
                                        href="{{ route('collaborationDetail', $book->slug) }}"
                                        class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-gray-900 px-5 py-3 text-[11px] font-black uppercase tracking-widest text-white shadow-lg transition-all hover:bg-black active:scale-95"
                                    >
                                        <i class="ki-filled ki-eye text-base"></i>
                                        Detail Proyek
                                    </a>

                                    @if($isUploadOpen)
                                        @if($module->file_path || $module->file_path_turnitin)
                                            <div class="grid grid-cols-1 gap-2 rounded-[1.5rem] border border-gray-100 bg-white p-3">
                                                @if($module->file_path)
                                                    <a href="{{ asset('storage/' . $module->file_path) }}" target="_blank" class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-50 px-4 py-3 text-[10px] font-black uppercase tracking-widest text-green-700 transition-all hover:bg-green-100">
                                                        <i class="ki-filled ki-document text-base"></i>
                                                        Lihat Naskah
                                                    </a>
                                                @endif

                                                @if($module->file_path_turnitin)
                                                    <a href="{{ asset('storage/' . $module->file_path_turnitin) }}" target="_blank" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-50 px-4 py-3 text-[10px] font-black uppercase tracking-widest text-blue-700 transition-all hover:bg-blue-100">
                                                        <i class="ki-filled ki-shield-search text-base"></i>
                                                        Lihat Turnitin
                                                    </a>
                                                @endif
                                            </div>
                                        @endif

                                        <form
                                            method="post"
                                            action="{{ route('account.collaboration.upload', $module->id) }}"
                                            enctype="multipart/form-data"
                                            class="rounded-[1.5rem] border border-gray-100 bg-gray-50/80 p-4 shadow-inner"
                                        >
                                            @csrf

                                            <div class="space-y-4">
                                                {{-- File Naskah --}}
                                                <div>
                                                    <label class="mb-2 block text-[10px] font-black uppercase tracking-widest text-gray-500">
                                                        File Naskah <span class="text-red-500">*</span>
                                                    </label>

                                                    <label class="group relative flex min-h-28 cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-gray-200 bg-white px-4 py-5 text-center transition-all hover:border-primary/70 hover:bg-primary/[0.03]">
                                                        <input
                                                            type="file"
                                                            name="file"
                                                            required
                                                            accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                                            class="absolute inset-0 z-10 cursor-pointer opacity-0 collaboration-file-input"
                                                        >

                                                        <div class="mb-3 flex size-11 items-center justify-center rounded-2xl bg-gray-50 text-gray-300 transition-all group-hover:bg-primary/10 group-hover:text-primary">
                                                            <i class="ki-filled ki-document text-2xl"></i>
                                                        </div>

                                                        <span class="block max-w-full truncate text-sm font-black text-gray-800 collaboration-file-name">
                                                            Pilih file naskah
                                                        </span>

                                                        <span class="mt-1 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                                                            PDF, DOC, DOCX · Maks. 10MB
                                                        </span>
                                                    </label>

                                                    @error('file')
                                                        <p class="mt-2 text-xs font-bold text-red-500">
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>

                                                {{-- Turnitin --}}
                                                <div>
                                                    <label class="mb-2 block text-[10px] font-black uppercase tracking-widest text-gray-500">
                                                        Turnitin
                                                    </label>

                                                    <label class="group relative flex cursor-pointer items-center gap-3 rounded-2xl border border-gray-200 bg-white px-4 py-4 transition-all hover:border-primary/50 hover:bg-primary/[0.03]">
                                                        <input
                                                            type="file"
                                                            name="turnitin_file"
                                                            accept=".pdf,application/pdf"
                                                            class="absolute inset-0 z-10 cursor-pointer opacity-0 collaboration-file-input"
                                                        >

                                                        <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-gray-50 text-gray-400 transition-all group-hover:bg-primary/10 group-hover:text-primary">
                                                            <i class="ki-filled ki-shield-search text-xl"></i>
                                                        </div>

                                                        <div class="min-w-0">
                                                            <span class="block max-w-full truncate text-xs font-black text-gray-700 collaboration-file-name">
                                                                Upload file turnitin
                                                            </span>
                                                            <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">
                                                                Opsional, PDF · Maks. 5MB
                                                            </span>
                                                        </div>
                                                    </label>

                                                    @error('turnitin_file')
                                                        <p class="mt-2 text-xs font-bold text-red-500">
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>

                                                <button
                                                    type="submit"
                                                    class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-primary px-5 py-3.5 text-[11px] font-black uppercase tracking-widest text-white shadow-lg shadow-primary/20 transition-all hover:bg-primary-dark active:scale-95"
                                                >
                                                    <i class="ki-filled ki-file-up text-base"></i>
                                                    Simpan Upload
                                                </button>
                                            </div>
                                        </form>
                                    @else
                                        <div class="rounded-[1.5rem] border border-green-100 bg-green-50 p-5 text-center">
                                            <div class="mx-auto mb-3 flex size-12 items-center justify-center rounded-2xl bg-white text-green-600 shadow-sm">
                                                <i class="ki-filled ki-check-circle text-2xl"></i>
                                            </div>

                                            <p class="text-sm font-black text-green-700">
                                                Upload Selesai
                                            </p>

                                            <p class="mt-1 text-xs font-bold text-green-600/80">
                                                Proyek sudah tidak menerima upload baru.
                                            </p>

                                            @if($module->file_path || $module->file_path_turnitin)
                                                <div class="mt-4 grid grid-cols-1 gap-2">
                                                    @if($module->file_path)
                                                        <a href="{{ asset('storage/' . $module->file_path) }}" target="_blank" class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-3 text-[10px] font-black uppercase tracking-widest text-green-700 shadow-sm transition-all hover:bg-green-100">
                                                            <i class="ki-filled ki-document text-base"></i>
                                                            Lihat Naskah
                                                        </a>
                                                    @endif

                                                    @if($module->file_path_turnitin)
                                                        <a href="{{ asset('storage/' . $module->file_path_turnitin) }}" target="_blank" class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-3 text-[10px] font-black uppercase tracking-widest text-blue-700 shadow-sm transition-all hover:bg-blue-100">
                                                            <i class="ki-filled ki-shield-search text-base"></i>
                                                            Lihat Turnitin
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="mt-10 flex justify-center">
            {{ $collaborators->links('landing.partials.pagination') }}
        </div>
    @else
        <div class="rounded-[3rem] border border-gray-100 bg-white px-6 py-20 text-center shadow-sm">
            <div class="mx-auto mb-6 flex size-20 items-center justify-center rounded-full bg-gray-50">
                <i class="ki-filled ki-users text-4xl text-gray-300"></i>
            </div>

            <h3 class="mb-2 text-xl font-black text-gray-900">
                Belum Ada Proyek Kolaborasi
            </h3>

            <p class="mx-auto mb-8 max-w-sm text-sm font-medium text-gray-500">
                Anda belum bergabung dalam proyek kolaborasi penulisan buku. Ayo bergabung dengan penulis lain!
            </p>

            <a
                href="{{ route('collaboration') }}"
                class="inline-flex rounded-2xl bg-primary px-10 py-4 text-sm font-black uppercase tracking-widest text-white shadow-xl shadow-primary/20 transition-all hover:scale-105"
            >
                Cari Proyek Kolaborasi
            </a>
        </div>
    @endif
</div>

@push('js')
<script>
    document.querySelectorAll('.collaboration-file-input').forEach((input) => {
        input.addEventListener('change', function () {
            const label = this.closest('label');
            const fileName = label.querySelector('.collaboration-file-name');

            if (fileName) {
                fileName.textContent = this.files && this.files.length > 0
                    ? this.files[0].name
                    : fileName.textContent;
            }

            if (this.files && this.files.length > 0) {
                label.classList.add('border-green-300', 'bg-green-50/50');
            }
        });
    });
</script>
@endpush
