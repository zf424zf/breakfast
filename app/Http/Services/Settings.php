<?php

namespace App\Http\Services;

/**
 * Created by PhpStorm.
 * User: skiden
 * Date: 2017/6/9
 * Time: 上午9:01
 */
use App\Models\Settings as SettingModel;
use Illuminate\Support\Arr;

/**
 * Class Settings
 * @package App\Http\Service
 * 获取系统配置项
 */
class Settings
{
    const CACHE_KEY = 'settings';

    protected $data = [];

    /**
     * Settings constructor.
     * 获取持久化数据
     */
    public function __construct()
    {
        if (!$this->data = cache()->get(self::CACHE_KEY)) {
            $data = SettingModel::all()->toArray();
            $this->data = array_column($data, 'value', 'key');
            cache()->put(self::CACHE_KEY, $this->data, 14400);
        }
    }

    /**
     * @param null $key
     * @param null $default 默认值
     * @return array|mixed|null
     * 获取配置项
     */
    public function get($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->data;
        }
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }
        return $default;
    }

    /**
     * @param $key
     * @param null $value
     * 设置设置项  不会保存至持久化数据  只对单次请求有效
     */
    public function set($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            Arr::set($this->data, $key, $value);
        }
    }

    /**
     * @return mixed
     * 删除配置项目缓存
     */
    public function clear()
    {
        return cache()->forget(self::CACHE_KEY);
    }

}