<?php
namespace Ademes\Core\User;

use Ademes\Core\models\User as User;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class UserClient extends \Ademes\Core\Http\Client {
    
    private $client;
    
    public function __construct() {
        $base_url = \Config::get('core::core.base_url');
        $this->client = new \GuzzleHttp\Client(['base_url'=>$base_url]);
    }
    
    public function getLoggedInUser($access_token) {
        try {
            $res = $this->client->get('v1/user/token/' . $access_token)->json();
            if (!empty($res) && array_key_exists('success_code', $res)) {
                $user = new User;
                $user->setId($res['data']['id']);
                $user->setName($res['data']['name']);
                $user->setEmail($res['data']['email']);
                $user->setUid($res['data']['uid']);
                return $user;
            }
            
        } catch (\Exception $exception) {
            \Log::error($exception);
            return false;
        }
    }
    
    public function updateUser(\Ademes\Core\models\User $user, $access_token) {
        
    }
}
