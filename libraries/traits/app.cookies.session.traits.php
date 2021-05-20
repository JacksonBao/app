<?php

namespace Traits;

use Table\Classes\Users;

trait CookiesSessionsTraits
{
    public function addCookie(string $name, $value, string $expires = '1 day', $path = '/', string $domain = 'thanosapi.dv', bool $secure = true, bool $http = true)
    {
        
        $orgVal = $value;
        if(is_array($value)) $value = json_encode($value);

        setcookie($name, $value, strtotime( '+'.$expires), $path);//, '', $secure, $http);
        $_SESSION['COOKIES'][$name] = $orgVal;
    }

    public function deleteCookie(string $name, $domain = 'thanosapi.dv')
    {
        setcookie($name, '',  strtotime('-1 day'), '/');//, $domain, true, true);
        unset($_SESSION['COOKIES'][$name]);
    }

    /**
     * GET SESSION COOKIE
     * @param string $name
     * @return mix content
     */
    public function getSessionCookie(string $name)
    {
        $cookies = @$_SESSION['COOKIES'] ?: [];
        if(array_key_exists($name, $cookies)){
            $content = $cookies[$name];
            $content = json_decode($content) ?: $content;
            return $content;
        } else {
            return false;
        }
    }
}