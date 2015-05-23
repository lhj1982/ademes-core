<?php
namespace Ademes\Core\models;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class User {
    
    private $id;
    private $email;
    private $name;
    private $uid;
    
    function getId() {
        return $this->id;
    }

    function getEmail() {
        return $this->email;
    }

    function getName() {
        return $this->name;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setName($name) {
        $this->name = $name;
    }
    function getUid() {
        return $this->uid;
    }

    function setUid($uid) {
        $this->uid = $uid;
    }



}
