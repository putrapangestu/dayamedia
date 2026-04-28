<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppTemplate extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_templates';

    protected $fillable = [
        'name',
        'template_key',
        'content',
        'variables',
        'status',
        'description',
    ];

    protected $casts = [
        'variables' => 'array',
    ];

    /**
     * Status constants
     */
    public const STATUS_ACTIVE = 'active';

    public const STATUS_INACTIVE = 'inactive';

    /**
     * Template key constants
     */
    public const TEMPLATE_ORDER_CONFIRMATION = 'order_confirmation';

    public const TEMPLATE_PAYMENT_REMINDER = 'payment_reminder';

    public const TEMPLATE_PAYMENT_CONFIRMATION = 'payment_confirmation';

    public const TEMPLATE_ORDER_COMPLETED = 'order_completed';

    public const TEMPLATE_ROYALTY_PAYMENT = 'royalty_payment';

    public const TEMPLATE_BOOK_PUBLISHED = 'book_published';

    public const TEMPLATE_EDITOR_APPROVED = 'editor_approved';

    /**
     * Process template with variables
     */
    public function process(array $variables = []): string
    {
        $content = $this->content;

        foreach ($variables as $key => $value) {
            $content = str_replace('{{'.$key.'}}', $value, $content);
        }

        return $content;
    }

    /**
     * Get template by key
     */
    public static function getByKey(string $key): ?self
    {
        return self::where('template_key', $key)
            ->where('status', self::STATUS_ACTIVE)
            ->first();
    }
}
