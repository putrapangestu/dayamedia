<?php

namespace App\Helpers;

use App\Models\Book;
use App\Models\BookEditor;

class StatusHelper
{
    /**
     * Get badge class for book status
     */
    public static function getBookStatusBadge(string $status): string
    {
        return match ($status) {
            Book::STATUS_OPEN => 'bg-info text-white',
            Book::STATUS_EDITING => 'bg-warning text-dark',
            Book::STATUS_PUBLISHED => 'bg-success text-white',
            Book::STATUS_UNPUBLISHED => 'bg-secondary text-white',
            Book::STATUS_CLOSED => 'bg-danger text-white',
            Book::STATUS_ARCHIVED => 'bg-dark text-white',
            default => 'bg-light text-dark'
        };
    }

    /**
     * Get badge class for book editor status
     */
    public static function getBookEditorStatusBadge(string $status): string
    {
        return match ($status) {
            BookEditor::STATUS_PENDING => 'bg-warning text-dark',
            BookEditor::STATUS_APPROVED => 'bg-success text-white',
            BookEditor::STATUS_REJECTED => 'bg-danger text-white',
            BookEditor::STATUS_COMPLETED => 'bg-primary text-white',
            default => 'bg-light text-dark'
        };
    }

    /**
     * Get badge class for file status
     */
    public static function getFileStatusBadge(string $status): string
    {
        return match ($status) {
            BookEditor::FILE_STATUS_PENDING => 'bg-warning text-dark',
            BookEditor::FILE_STATUS_APPROVED => 'bg-success text-white',
            BookEditor::FILE_STATUS_REJECTED => 'bg-danger text-white',
            BookEditor::FILE_STATUS_REVISION => 'bg-info text-white',
            default => 'bg-light text-dark'
        };
    }

    /**
     * Get status text in Indonesian
     */
    public static function getStatusText(string $status): string
    {
        return match ($status) {
            Book::STATUS_OPEN => 'Terbuka',
            Book::STATUS_EDITING => 'Proses Edit',
            Book::STATUS_PUBLISHED => 'Diterbitkan',
            Book::STATUS_UNPUBLISHED => 'Tidak Diterbitkan',
            Book::STATUS_CLOSED => 'Ditutup',
            Book::STATUS_ARCHIVED => 'Diarsipkan',
            BookEditor::STATUS_PENDING => 'Menunggu',
            BookEditor::STATUS_APPROVED => 'Disetujui',
            BookEditor::STATUS_REJECTED => 'Ditolak',
            BookEditor::STATUS_COMPLETED => 'Selesai',
            BookEditor::FILE_STATUS_PENDING => 'Menunggu Review',
            BookEditor::FILE_STATUS_APPROVED => 'Disetujui',
            BookEditor::FILE_STATUS_REJECTED => 'Ditolak',
            BookEditor::FILE_STATUS_REVISION => 'Perlu Revisi',
            default => ucfirst($status)
        };
    }
}
