<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookEditor extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'book_editors';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * The status of the book editor.
     */
    public const STATUS_PENDING = 'pending';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_REJECTED = 'rejected';

    public const STATUS_COMPLETED = 'completed';

    /**
     * The file status of the book editor.
     */
    public const FILE_STATUS_PENDING = 'pending';

    public const FILE_STATUS_APPROVED = 'approved';

    public const FILE_STATUS_REJECTED = 'rejected';

    public const FILE_STATUS_REVISION = 'revision';

    protected $fillable = [
        'book_id',
        'user_id',
        'status',
        'file_path',
        'file_turnitin',
        'notes',
        'file_status',
        'revision_notes',
        'file_submitted_at',
        'file_reviewed_at',
        'file_revision_path',
    ];

    /**
     *  Get the book that owns the editor.
     */
    public function book()
    {
        return $this->belongsTo(Book::class)->withTrashed();
    }

    /**
     *  Get the user that is the editor.
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
