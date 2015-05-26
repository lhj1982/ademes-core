<?php
namespace Ademes\Core\Http;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use GuzzleHttp\Post\PostFile;
class Client {

    public $client;

    public function __construct() {
        $base_url = \Config::get('core::core.base_url');
        $this->client = new \GuzzleHttp\Client(['base_url'=>$base_url]);
    }

    public function postFile($field_name, $content)
    {
        return new PostFile($field_name, $content);
    }
}