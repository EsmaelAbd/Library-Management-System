<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('format_date')) {
    /**
     * Format a DateTime to a more readable format.
     *
     * @param string|DateTime $date
     * @param string $format
     * @return string
     */
    function format_date($date, $format = 'Y-m-d H:i:s')
    {
        if (!$date instanceof DateTime) {
            $date = new DateTime($date);
        }
        return $date->format($format);
    }
}

if (!function_exists('cache_data')) {
    /**
     * Cache the given data with a specified key and duration.
     *
     * @param string $key
     * @param mixed $value
     * @param int $duration Duration to cache data for, in seconds
     * @return mixed
     */
    function cache_data($key, $value = null, $duration = 60)
    {
        $cache = app('cache');

        if ($value === null) {
            return $cache->get($key);
        }

        $cache->put($key, $value, now()->addSeconds($duration));
        return $value;
    }
}

if (!function_exists('log_custom_analytics')) {
    /**
     * Log custom analytics data.
     *
     * @param string $message
     * @param array $data
     * @return void
     */
    function log_custom_analytics($message, $data = [])
    {
        $logData = [
            'date' => now()->toDateTimeString(),
            'message' => $message,
            'data' => $data,
        ];
        Log::channel('custom_analytics')->info(json_encode($logData));
    }
}
