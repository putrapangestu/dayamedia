@extends('landing.layouts.app')

@section('content')
    <div class="kt-container-fixed">

        <div class="grid gap-5 lg:gap-7.5 mt-6 mb-6">
            <div class="kt-scrollable-x-auto pt-3 -mt-3">
                <table
                    class="kt-table table-fixed border-separate border-spacing-0 min-w-[1000px] rounded-xl rtl:[&amp;_tr:nth-of-type(12)&gt;td:last-child]:rounded-bl-xl [&amp;_tr:nth-of-type(2)&gt;td]:border-t ltr:[&amp;_tr:nth-of-type(12)&gt;td:last-child]:rounded-br-xl ltr:[&amp;_tr:nth-of-type(12)&gt;td:first-child]:rounded-bl-xl rtl:[&amp;_tr:nth-of-type(12)&gt;td:first-child]:rounded-br-xl ltr:[&amp;_tr:nth-of-type(2)&gt;td:first-child]:rounded-tl-xl rtl:[&amp;_tr:nth-of-type(2)&gt;td:first-child]:rounded-tr-xl">
                    <tbody>
                        <tr class="*:border-border">
                            <td class="border-b-0 align-bottom p-5! pt-7.5!">

                            </td>
                            <td class="border-t ltr:border-l rtl:border-s p-5! pt-7.5!">
                                <h3 class="text-lg text-mono font-medium pb-2">
                                    Paket Basic
                                </h3>
                                <div class="text-secondary-foreground text-sm">
                                    <span class="kt-badge kt-badge-outline">
                                        3 Penulis
                                    </span>
                                </div>
                                <div class="py-4">
                                    <div class="flex items-end gap-1.5" data-kt-plan-type="pro">
                                        <div class="text-2xl text-mono font-semibold leading-none"
                                            data-kt-plan-price-annual="$79" data-kt-plan-price-regular="$99">
                                            Rp.700.000
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button class="kt-btn kt-btn-primary text-center flex justify-center w-full">
                                        Pilih
                                    </button>
                                </div>
                            </td>
                            <td class="border-t ltr:border-l rtl:border-s p-5! pt-7.5!">
                                <h3 class="text-lg text-mono font-medium pb-2">
                                    Paket Pro
                                </h3>
                                <div class="text-secondary-foreground text-sm">
                                    <span class="kt-badge kt-badge-outline">
                                        3 Penulis
                                    </span>
                                </div>
                                <div class="py-4">
                                    <div class="flex items-end gap-1.5" data-kt-plan-type="premium">
                                        <div class="text-2xl text-mono font-semibold leading-none"
                                            data-kt-plan-price-annual="$179" data-kt-plan-price-regular="$199">
                                            Rp.1.100.000
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button class="kt-btn kt-btn-primary text-center flex justify-center w-full">
                                        Pilih
                                    </button>
                                </div>
                            </td>
                            <td
                                class="border-t ltr:border-l rtl:border-s ltr:rounded-tr-xl rtl:rounded-tl-xl border-e p-5! pt-7.5!">
                                <h3 class="text-lg text-mono font-medium pb-2">
                                    Paket Bisnis
                                </h3>
                                <div class="text-secondary-foreground text-sm">
                                    <span class="kt-badge kt-badge-outline">
                                        3 Penulis
                                    </span>
                                </div>
                                <div class="py-4">
                                    <div class="flex items-end gap-1.5" data-kt-plan-type="enterprise">
                                        <div class="text-2xl text-mono font-semibold leading-none"
                                            data-kt-plan-price-annual="$1,079" data-kt-plan-price-regular="$1,299">
                                            Rp.1.500.000
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button class="kt-btn kt-btn-primary text-center flex justify-center w-full">
                                        Pilih
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="*:border-border">
                            <td class="border-s border-b px-5! py-3.5!">
                                <div class="text-mono text-sm leading-none font-medium">
                                    Ebook Ber-ISBN
                                </div>
                            </td>
                            <td class="border-b border-s px-5! py-3.5!">
                                <i class="ki-filled ki-check text-green-500 text-lg">
                                </i>
                            </td>
                            <td class="border-b border-s px-5! py-3.5!">
                                <i class="ki-filled ki-check text-green-500 text-lg">
                                </i>
                            </td>
                            <td class="border-b border-s border-e px-5! py-3.5!">
                                <i class="ki-filled ki-check text-green-500 text-lg">
                                </i>
                            </td>
                        </tr>
                        <tr class="*:border-border">
                            <td class="border-s border-b px-5! py-3.5!">
                                <div class="text-mono text-sm leading-none font-medium">
                                    Desain Cover
                                </div>
                            </td>
                            <td class="border-b border-s px-5! py-3.5!">
                                <i class="ki-filled ki-check text-green-500 text-lg">
                                </i>
                            </td>
                            <td class="border-b border-s px-5! py-3.5!">
                                <i class="ki-filled ki-check text-green-500 text-lg">
                                </i>
                            </td>
                            <td class="border-b border-s border-e px-5! py-3.5!">
                                <i class="ki-filled ki-check text-green-500 text-lg">
                                </i>
                            </td>
                        </tr>
                        <tr class="*:border-border">
                            <td class="border-s border-b px-5! py-3.5!">
                                <div class="text-mono text-sm leading-none font-medium">
                                    Editting
                                </div>
                            </td>
                            <td class="border-b border-s px-5! py-3.5!">
                                <i class="ki-filled ki-check text-green-500 text-lg">
                                </i>
                            </td>
                            <td class="border-b border-s px-5! py-3.5!">
                                <i class="ki-filled ki-check text-green-500 text-lg">
                                </i>
                            </td>
                            <td class="border-b border-s border-e px-5! py-3.5!">
                                <i class="ki-filled ki-check text-green-500 text-lg">
                                </i>
                            </td>
                        </tr>
                        <tr class="*:border-border">
                            <td class="border-s border-b px-5! py-3.5!">
                                <div class="text-mono text-sm leading-none font-medium">
                                    Sertifikat Penulis
                                </div>
                            </td>
                            <td class="border-b border-s px-5! py-3.5!">
                                <i class="ki-filled ki-check text-green-500 text-lg">
                                </i>
                            </td>
                            <td class="border-b border-s px-5! py-3.5!">
                                <i class="ki-filled ki-check text-green-500 text-lg">
                                </i>
                            </td>
                            <td class="border-b border-s border-e px-5! py-3.5!">
                                <i class="ki-filled ki-check text-green-500 text-lg">
                                </i>
                            </td>
                        </tr>
                        <tr class="*:border-border">
                            <td class="border-s border-b px-5! py-3.5!">
                                <div class="text-mono text-sm leading-none font-medium">
                                    Royalti Penjualan 20%
                                </div>
                            </td>
                            <td class="border-b border-s px-5! py-3.5!">
                                <i class="ki-filled ki-check text-green-500 text-lg">
                                </i>
                            </td>
                            <td class="border-b border-s px-5! py-3.5!">
                                <i class="ki-filled ki-check text-green-500 text-lg">
                                </i>
                            </td>
                            <td class="border-b border-s border-e px-5! py-3.5!">
                                <i class="ki-filled ki-check text-green-500 text-lg">
                                </i>
                            </td>
                        </tr>
                        <tr class="*:border-border">
                            <td class="border-s border-b px-5! py-3.5!">
                                <div class="text-mono text-sm leading-none font-medium">
                                    Terindeks Google Scholar
                                </div>
                            </td>
                            <td class="border-b border-s px-5! py-3.5!">
                                <i class="ki-filled ki-check text-green-500 text-lg">
                                </i>
                            </td>
                            <td class="border-b border-s px-5! py-3.5!">
                                <i class="ki-filled ki-check text-green-500 text-lg">
                                </i>
                            </td>
                            <td class="border-b border-s border-e px-5! py-3.5!">
                                <i class="ki-filled ki-check text-green-500 text-lg">
                                </i>
                            </td>
                        </tr>
                        <tr class="*:border-border">
                            <td class="border-s border-b px-5! py-3.5!">
                                <div class="text-mono text-sm leading-none font-medium">
                                    Sertifikat HKI
                                </div>
                            </td>
                            <td class="border-b border-s px-5! py-3.5!">
                                 <i class="ki-filled ki-cross text-red-500 text-lg">
                                </i>
                            </td>
                            <td class="border-b border-s px-5! py-3.5!">
                                <i class="ki-filled ki-check text-green-500 text-lg">
                                </i>
                            </td>
                            <td class="border-b border-s border-e px-5! py-3.5!">
                                <i class="ki-filled ki-check text-green-500 text-lg">
                                </i>
                            </td>
                        </tr>
                        <tr class="*:border-border">
                            <td class="border-s border-b px-5! py-3.5!">
                                <div class="text-mono text-sm leading-none font-medium">
                                    Buku Cetak 5 Eksamplar
                                </div>
                            </td>
                            <td class="border-b border-s px-5! py-3.5!">
                                <i class="ki-filled ki-cross text-red-500 text-lg">
                                </i>
                            </td>
                            <td class="border-b border-s px-5! py-3.5!">
                                <i class="ki-filled ki-cross text-red-500 text-lg">
                                </i>
                            </td>
                            <td class="border-b border-s border-e px-5! py-3.5!">
                                <i class="ki-filled ki-check text-green-500 text-lg">
                                </i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
