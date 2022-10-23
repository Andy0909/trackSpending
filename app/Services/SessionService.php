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

    public function getSession(string $getItem): string
    {
        return Session::get($getItem);
    }

    public function forgetSession(string $forgetItem): void
    {
        Session::forget($forgetItem);
    }
    
    public function removeSession(): void
    {
        Session::flush();
    }
}