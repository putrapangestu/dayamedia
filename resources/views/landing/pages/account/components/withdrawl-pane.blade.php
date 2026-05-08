<div class="grid gap-5 lg:gap-7.5">
    <div class="kt-card kt-card-grid min-w-full">
        <div class="kt-card-header py-5 flex-wrap">
            <h3 class="kt-card-title">
                Riwayat Withdraw
            </h3>

            <button class="kt-btn kt-btn-sm kt-btn-primary bg-primary/10 text-primary hover:bg-primary/20">
                <i class="ki-outline ki-plus text-primary text-base"></i>
                Tambah Withdraw
            </button>
        </div>
        <div class="kt-card-content">
            <div class="grid datatable-initialized" data-kt-datatable="true"
                data-kt-datatable-page-size="10" data-kt-datatable-initialized="true">
                <div class="kt-scrollable-x-auto">
                    <table class="kt-table table-auto kt-table-border" data-kt-datatable-table="true" id="buku_table">
                        <thead>
                            <tr>
                                <th class="w-[55px]" aria-sort="none">
                                    No
                                </th>
                                <th class="" aria-sort="none">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Rekening</span>
                                    </span>
                                </th>
                                <th class="min-w-[250px]" aria-sort="none">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Jumlah</span>
                                    </span>
                                </th>
                                <th class="" aria-sort="none">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Status</span>
                                    </span>
                                </th>
                                <th class="w-[120px]" aria-sort="none">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td class="text-sm text-foreground font-normal">1</td>
                                <td>
                                    <div class="flex flex-col gap-0.5">
                                        <span class="leading-none font-medium text-mono">BCA-120391023912-</span>
                                        <span class="text-xs text-muted">Atas nama: sdasdasd</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="flex flex-col gap-0.5">
                                            <span class="leading-none font-medium text-sm text-mono">
                                                Rp.200.000
                                            </span>
                                            <span class="text-xs text-muted-foreground font-normal">
                                                Potongan Saldo: Rp.50.000
                                            </span>
                                            <span class="text-xs text-muted-foreground font-normal">
                                                Biaya Admin: Rp.0
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex flex-col items-start gap-0.5">
                                        <span class="text-sm text-green-600 font-medium bg-green-50 p-2 rounded-xl">Selesai</span>
                                        <span class="text-xs text-muted-foreground font-normal">
                                            02 April 2026 15:03:34
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <a class="kt-btn kt-btn-sm kt-btn-primary text-white" href="#">
                                        <i class="ki-filled ki-trash"></i>
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div
                    class="kt-card-footer justify-center md:justify-between flex-col md:flex-row gap-5 text-secondary-foreground text-sm font-medium">
                    <div class="flex items-center gap-2 order-2 md:order-1">
                        Show
                        <select class="hidden" data-kt-datatable-size="true" data-kt-select=""
                            name="perpage" data-kt-select-initialized="true">
                            <option value="5" data-kt-select-option-initialized="true">5</option>
                            <option value="10" data-kt-select-option-initialized="true">10</option>
                            <option value="20" data-kt-select-option-initialized="true">20</option>
                            <option value="30" data-kt-select-option-initialized="true">30</option>
                            <option value="50" data-kt-select-option-initialized="true">50</option>
                        </select>
                        <div data-kt-select-wrapper="" class="kt-select-wrapper w-16">
                            <div data-kt-select-display="" class="kt-select-display kt-select"
                                tabindex="0" role="button" data-selected="0" aria-haspopup="listbox"
                                aria-expanded="false" aria-label="Select an option">
                                <div class="kt-select-option-text" data-kt-text-container="true">10</div>
                            </div>
                            <div data-kt-select-dropdown="" class="kt-select-dropdown hidden "
                                style="z-index: 105;">
                                <ul role="listbox" aria-label="Select an option"
                                    class="kt-select-options " data-kt-select-options="true">
                                    <li data-kt-select-option="" data-value="5" data-text="5"
                                        class="kt-select-option" role="option" aria-selected="false">
                                        <div class="kt-select-option-text" data-kt-text-container="true">5
                                        </div><svg viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="size-3.5 ms-auto hidden text-primary kt-select-option-selected:block">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg>
                                    </li>
                                    <li data-kt-select-option="" data-value="10" data-text="10"
                                        class="kt-select-option selected" role="option"
                                        aria-selected="true">
                                        <div class="kt-select-option-text" data-kt-text-container="true">
                                            10</div><svg viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="size-3.5 ms-auto hidden text-primary kt-select-option-selected:block">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg>
                                    </li>
                                    <li data-kt-select-option="" data-value="20" data-text="20"
                                        class="kt-select-option" role="option" aria-selected="false">
                                        <div class="kt-select-option-text" data-kt-text-container="true">
                                            20</div><svg viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="size-3.5 ms-auto hidden text-primary kt-select-option-selected:block">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg>
                                    </li>
                                    <li data-kt-select-option="" data-value="30" data-text="30"
                                        class="kt-select-option" role="option" aria-selected="false">
                                        <div class="kt-select-option-text" data-kt-text-container="true">
                                            30</div><svg viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="size-3.5 ms-auto hidden text-primary kt-select-option-selected:block">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg>
                                    </li>
                                    <li data-kt-select-option="" data-value="50" data-text="50"
                                        class="kt-select-option" role="option" aria-selected="false">
                                        <div class="kt-select-option-text" data-kt-text-container="true">
                                            50</div><svg viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="size-3.5 ms-auto hidden text-primary kt-select-option-selected:block">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        per page
                    </div>
                    <div class="flex items-center gap-4 order-1 md:order-2">
                        <span data-kt-datatable-info="true">1-10 of 31</span>
                        <div class="kt-datatable-pagination" data-kt-datatable-pagination="true"><button
                                class="kt-datatable-pagination-button kt-datatable-pagination-prev disabled"
                                disabled="">
                                <svg class="rtl:transform rtl:rotate-180 size-3.5 shrink-0" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8.86501 16.7882V12.8481H21.1459C21.3724 12.8481 21.5897 12.7581 21.7498 12.5979C21.91 12.4378 22 12.2205 22 11.994C22 11.7675 21.91 11.5503 21.7498 11.3901C21.5897 11.2299 21.3724 11.1399 21.1459 11.1399H8.86501V7.2112C8.86628 7.10375 8.83517 6.9984 8.77573 6.90887C8.7163 6.81934 8.63129 6.74978 8.53177 6.70923C8.43225 6.66869 8.32283 6.65904 8.21775 6.68155C8.11267 6.70405 8.0168 6.75766 7.94262 6.83541L2.15981 11.6182C2.1092 11.668 2.06901 11.7274 2.04157 11.7929C2.01413 11.8584 2 11.9287 2 11.9997C2 12.0707 2.01413 12.141 2.04157 12.2065C2.06901 12.272 2.1092 12.3314 2.15981 12.3812L7.94262 17.164C8.0168 17.2417 8.11267 17.2953 8.21775 17.3178C8.32283 17.3403 8.43225 17.3307 8.53177 17.2902C8.63129 17.2496 8.7163 17.18 8.77573 17.0905C8.83517 17.001 8.86628 16.8956 8.86501 16.7882Z"
                                        fill="currentColor"></path>
                                </svg>
                            </button><button class="kt-datatable-pagination-button active disabled"
                                disabled="">1</button><button
                                class="kt-datatable-pagination-button">2</button><button
                                class="kt-datatable-pagination-button">3</button><button
                                class="kt-datatable-pagination-button kt-datatable-pagination-more">...</button><button
                                class="kt-datatable-pagination-button kt-datatable-pagination-next">
                                <svg class="rtl:transform rtl:rotate-180 size-3.5 shrink-0" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.135 7.21144V11.1516H2.85407C2.62756 11.1516 2.41032 11.2415 2.25015 11.4017C2.08998 11.5619 2 11.7791 2 12.0056C2 12.2321 2.08998 12.4494 2.25015 12.6096C2.41032 12.7697 2.62756 12.8597 2.85407 12.8597H15.135V16.7884C15.1337 16.8959 15.1648 17.0012 15.2243 17.0908C15.2837 17.1803 15.3687 17.2499 15.4682 17.2904C15.5677 17.3309 15.6772 17.3406 15.7822 17.3181C15.8873 17.2956 15.9832 17.242 16.0574 17.1642L21.8402 12.3814C21.8908 12.3316 21.931 12.2722 21.9584 12.2067C21.9859 12.1412 22 12.0709 22 11.9999C22 11.9289 21.9859 11.8586 21.9584 11.7931C21.931 11.7276 21.8908 11.6683 21.8402 11.6185L16.0574 6.83565C15.9832 6.75791 15.8873 6.70429 15.7822 6.68179C15.6772 6.65929 15.5677 6.66893 15.4682 6.70948C15.3687 6.75002 15.2837 6.81959 15.2243 6.90911C15.1648 6.99864 15.1337 7.10399 15.135 7.21144Z"
                                        fill="currentColor"></path>
                                </svg>
                            </button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
