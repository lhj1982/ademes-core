<?php
namespace Ademes\Core\Exception;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


use Ademes\Core\Exception\CoreException as CoreException;

class SolrException extends CoreException {

    public function __construct($code, $message) {
        $this->httpStatusCode = $code;
        $this->errorType = 'solr_error';
        parent::__construct($message);
    }
}
