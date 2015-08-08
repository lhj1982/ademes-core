<?php
namespace Ademes\Core\models;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class AuthResponse {
    
    private $accessToken;
    private $refreshToken;
    private $userReference;
    
    function getAccessToken() {
        return $this->accessToken;
    }

    function getRefreshToken() {
        return $this->refreshToken;
    }

    function getUserReference() {
        return $this->userReference;
    }

    function setAccessToken($accessToken) {
        $this->accessToken = $accessToken;
    }

    function setRefreshToken($refreshToken) {
        $this->refreshToken = $refreshToken;
    }

    function setUserReference($userReference) {
        $this->userReference = $userReference;
    }


}

