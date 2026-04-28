<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
        'group',
    ];

    protected $casts = [
        'value' => 'json',
    ];

    /**
     * Get setting value by key
     */
    public static function get(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();

        return $setting ? $setting->value : $default;
    }

    /**
     * Get setting value by key (alias)
     */
    public static function getValue(string $key, $default = null)
    {
        return self::get($key, $default);
    }

    /**
     * Set setting value
     */
    public static function set(string $key, $value, string $type = 'string', string $description = '', string $group = 'general')
    {
        return self::updateOrCreate(
            ['key' => $key],
            [
                'id' => self::where('key', $key)->first()?->id ?? (string) \Illuminate\Support\Str::uuid(),
                'value' => $value,
                'type' => $type,
                'description' => $description,
                'group' => $group,
            ]
        );
    }
}
