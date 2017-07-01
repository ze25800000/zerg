<?php

namespace app\api\service;


class UserToken {
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code) {
        $this->code        = $code;
        $this->wxAppID     = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl  = sprintf(config('wx.login_url'), $this->wxAppID, $this->wxAppSecret, $this->code);
    }

    public function get() {

    }
}