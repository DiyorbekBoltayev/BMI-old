<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class HemisService
{
    public static function login($login,$password)
    {
        $client = new Client(['verify' => false]);
        $options = [
            'multipart' => [
                [
                    'name' => 'login',
                    'contents' => "{$login}"
                ],
                [
                    'name' => 'password',
                    'contents' => "{$password}"
                ]
            ]];
        $request = new Request('POST', 'https://student.ubtuit.uz/rest/v1/auth/login');
        $res = $client->sendAsync($request, $options)->wait();
        $a=json_decode($res->getBody());
        if ($a->success){
            session()->put('hemistoken',$a->data->token);
            session()->put('loggedin',true);
        }
        self::getMe();
        return $a->success;

    }
    public static function getMe(){

        $token=session()->get('hemistoken');
        $client = new Client(['verify' => false]);
        $headers = [
            'Authorization' => 'Bearer '.$token,

        ];
        $request = new Request('GET', 'https://student.ubtuit.uz/rest/v1/account/me', $headers);
        $res = $client->sendAsync($request)->wait();
        $a=json_decode($res->getBody());
        if ($a->success){
            session()->put('hemisaboutme',$a->data);
            session()->put('hemisshortname',$a->data->short_name);
            session()->put('hemisimage',$a->data->image);
        }
        return $a->success;


    }



}