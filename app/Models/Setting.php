<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasUuids;

    protected $fillable = ['key', 'value', 'type'];

    /**
     * Get a setting value by key.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        $setting = Cache::rememberForever("setting.{$key}", function () use ($key) {
            return self::where('key', $key)->first();
        });

        if (! $setting) {
            return $default;
        }

        return self::castValue($setting->value, $setting->type);
    }

    /**
     * Set a setting value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @param  string|null  $type
     * @return void
     */
    public static function set($key, $value, $type = null)
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => (string) $value,
                'type' => $type ?? self::determineType($value),
            ]
        );

        Cache::forget("setting.{$key}");
    }

    /**
     * Cast the value based on the type.
     */
    protected static function castValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
            case 'bool':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
            case 'int':
                return (int) $value;
            default:
                return $value;
        }
    }

    /**
     * Determine the type based on the value.
     */
    protected static function determineType($value)
    {
        if (is_bool($value)) {
            return 'boolean';
        }
        if (is_numeric($value)) {
            return 'integer';
        }

        return 'string';
    }
}
