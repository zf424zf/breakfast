<?php
/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 2017/6/9
 * Time: 上午9:11
 */


if (!function_exists('setting')) {
    /**
     * Get / set the specified setting value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string $key
     * @param  mixed $default
     * @return mixed
     */
    function setting($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('setting')->get();
        }

        if (is_array($key)) {
            return app('setting')->set($key);
        }

        return app('setting')->get($key, $default);
    }
}


if (!function_exists('chinese_month')) {

    function chinese_month($timestamp = null)
    {
        $map = [
            '01' => '一月',
            '02' => '二月',
            '03' => '三月',
            '04' => '四月',
            '05' => '五月',
            '06' => '六月',
            '07' => '七月',
            '08' => '八月',
            '09' => '九月',
            '10' => '十月',
            '11' => '十一月',
            '12' => '十二月',
        ];
        $timestamp = is_null($timestamp) ? time() : $timestamp;
        $index = date('m', $timestamp);
        if (isset($map[$index])) {
            return $map[$index];
        }
        return null;
    }

}

if (!function_exists('cdn')) {

    function cdn($file)
    {
        $source = rtrim(env('CDN_URL', '/static/'), '/') . '/' . trim($file, '/');
        return $source . '?' . env('APP_VERSION', time());
    }

}