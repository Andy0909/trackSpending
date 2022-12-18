<?php 

namespace App\Services;

use Illuminate\Support\Facades\Session;

class SessionService
{
    public function setSession(array $setItems): void
    {
        collect($setItems)->each(function($item, $key){
            Session::put($key, $item);
        });
    }

    public function getSession(string $item): string
    {
        return is_null(Session::get($item)) ? '' : Session::get($item);
    }

    public function forgetSession(string $item): void
    {
        Session::forget($item);
    }
    
    public function removeSession(): void
    {
        Session::flush();
    }
}