<?php
namespace Ademes\Core\Http;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Client {

    public $client;

    public function __construct() {
        $base_url = \Config::get('core::core.base_url');
        $this->client = new \GuzzleHttp\Client(['base_url'=>$base_url]);
    }
}