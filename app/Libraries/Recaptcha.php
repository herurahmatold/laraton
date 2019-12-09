<?php

namespace App\Libraries;

use GuzzleHttp\Client;
use DB;


class Recaptcha
{
    protected $recaptcha_key = '';
    protected $recaptcha_secret = '';

    function __construct()
    {
        $this->recaptcha_key = $this->init_config('app_recaptcha_key');
        $this->recaptcha_secret = $this->init_config('app_recaptcha_secret');
    }

    private function init_config($key)
    {
        $check = DB::table('options')->where('option_key', $key)->count();
        if ($check < 1) {
            DB::table('options')->insert([
                'option_key' => $key
            ]);
        }
        return option_get($key);
    }


    public function generate()
    {
        if(!empty($this->recaptcha_key))
        {
            return '<p style="margin-top:10px;margin-botton:10px"><script src="https://www.google.com/recaptcha/api.js"></script><div class="g-recaptcha" data-sitekey="'.$this->recaptcha_key.'"></div></p>';
        }
    }

    public function validate($request)
    {
        if(!empty($this->recaptcha_secret))
        {
            $client = new Client;
            $response = $client->post(
                'https://www.google.com/recaptcha/api/siteverify',
                [
                    'form_params' =>
                    [
                        'secret' => $this->recaptcha_secret,
                        'response' => $request
                    ]
                ]
            );
            $body = json_decode((string) $response->getBody());
            return $body->success;
        }else{
            return true;
        }
    }
}
