<?php 

namespace App\Services;

use Illuminate\Support\Facades\Session;

class SessionService
{
    /**
     * setSession
     * @param array $setItems
     * @return void
     */
    public function setSession(array $setItems): void
    {
        collect($setItems)->each(function($item, $key){
            Session::put($key, $item);
        });
    }

    /**
     * getSession
     * @param string $item
     * @return string
     */
    public function getSession(string $item): string
    {
        return is_null(Session::get($item)) ? '' : Session::get($item);
    }

    /**
     * forgetSession
     * @param string $item
     * @return void
     */
    public function forgetSession(string $item): void
    {
        Session::forget($item);
    }
    
    /**
     * removeSession
     * @return void
     */
    public function removeSession(): void
    {
        Session::flush();
    }
}