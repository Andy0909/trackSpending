<?php 

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * setCache
     * @param array $setItems
     * @return void
     */
    public function setCache(array $setItems): void
    {
        collect($setItems)->each(function($item, $key){
            Cache::put($key, $item, 3600);
        });
    }

    /**
     * getCache
     * @param string $key
     * @return string
     */
    public function getCache(string $key): string
    {
        return Cache::get($key, '');
    }

    /**
     * forgetCache
     * @param string $key
     * @return void
     */
    public function forgetCache(string $key): void
    {
        Cache::forget($key);
    }
    
    /**
     * removeCache
     * @return void
     */
    public function removeCache(): void
    {
        Cache::flush();
    }

    /**
     * 缓存並返回數據
     * @param string $key
     * @param int $seconds
     * @param \Closure $callback
     * @return mixed
     */
    public function rememberCache(string $key, int $seconds, \Closure $callback): mixed
    {
        return Cache::remember($key, $seconds, $callback);
    }
}