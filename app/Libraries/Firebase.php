<?php

namespace App\Libraries;
use DB;


class Firebase
{
    protected $fb_key = '';
    protected $fb_db = '';
    protected $fb_sender = '';

    function __construct()
    {
        $this->fb_key = $this->init_config('app_firebase_key');
        $this->fb_db = $this->init_config('app_firebase_db_url');
        $this->fb_sender = $this->init_config('app_firebase_sender');

    }

    private function init_config($key)
    {
        $check=DB::table('options')->where('option_key',$key)->count();
        if($check < 1)
        {
            DB::table('options')->insert([
                'option_key' => $key
            ]);
        }
        return option_get($key);
    }


    public function send($token_list, $type, $title, $subject, $pdf_file = '')
    {
        $client = new \Fcm\FcmClient($this->fb_key, $this->fb_sender);
        $notification = new \Fcm\Push\Notification();
        $create_date = date('Y-m-d H:i:s');

        $notification
            ->addRecipient($token_list)
            ->setTitle($title)
            ->setBody($subject)
            ->addData('type', $type)
            ->addData('create', $create_date);
        if (!empty($pdf_file)) {
            $notification->addData('pdf', $pdf_file);
        }


        $client->send($notification);
    }
}
