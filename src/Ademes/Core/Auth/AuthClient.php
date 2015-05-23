<?php
namespace Ademes\Core\Auth;

use Ademes\Core\models\AuthResponse as AuthResponse;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class AuthClient {
    
    /**
     * 
     * @param type $username
     * @param type $password
     * @param type $client_id
     * @param type $secret
     * @return string access token if authenticated, otherwise, return false
     */
    public function authenticate($username, $password, $client_id, $secret) {
        $base_url = \Config::get('core::core.base_url');
        $client = new \GuzzleHttp\Client(['base_url'=>$base_url]);
        $data = [
            'body'=> ['grant_type' => 'password',
                'client_id' => $client_id,
                'client_secret' => $secret,
                'username' => $username,
                'password' => $password]
        ];
        try {
            $res = $client->post('oauth/access_token', $data)->json();
        } catch (\Exception $exception) {
            \Log::error($exception);
            return false;
        }
        $response = new AuthResponse();
        $response->setAccessToken($res['access_token']);
        $response->setRefreshToken($res['refresh_token']);
        
        
        
        return $response;
    }
    
    private function findUserByToken($access_token) {
        
    }
}
