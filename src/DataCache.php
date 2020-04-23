<?php

/**
 * User: Supen
 * Date: 2019-02-26
 * Time: 08:48
 */

namespace Supen\Supports;

use Illuminate\Support\Facades\Cache;

class DataCache
{
    /**
     * 构造函数
     */
    public function __construct()
    {
    }

    /**
     * 设置临时数据缓存
     * @param  string $key     缓存索引
     * @param  [type] $value   要缓存的数据
     * @param  [type] $minutes 缓存时间，分钟为单位
     * @return [type]          [description]
     */
    public static function put(string $key, $value, $minutes = 2880)
    {
        return Cache::put($key, $value, $minutes * 60);
    }

    /**
     * 通过缓存key取得数据后并清理key的缓存数据
     * @param  string $key [description]
     * @return [type]      [description]
     */
    public static function pull(string $key)
    {
        if (!Cache::has($key)) {
            return null;
        }

        return Cache::pull($key);
    }

    /**
     * 判断key索引是否存在
     * @param  string  $key [description]
     * @return boolean      [description]
     */
    public static function has(string $key)
    {
        return Cache::has($key);
    }

    /**
     * 获取key索引对应的缓存数据
     * @param  string $key     [description]
     * @param  [type] $default [description]
     * @return [type]          [description]
     */
    public static function get(string $key, $default = null)
    {
        return Cache::get($key, $default);
    }

    /**
     * 获取持久性缓存数据。
     * @param  string  $key 索引key
     * @param  Closure $fun 若值不存在时通过该回调函数重写缓存数据并返回
     * @return [type]       [description]
     */
    public static function rememberForever(string $key, $fun)
    {
        return Cache::rememberForever($key, $fun);
    }

    /**
     * 写入持久性数据
     * @param  string $key   [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function forever(string $key, $value)
    {
        return Cache::forever($key, $value);
    }

    /**
     * 删除索引对应的缓存数据
     * @param  string $key [description]
     * @return [type]      [description]
     */
    public static function forget(string $key)
    {
        return Cache::forget($key);
    }
}
