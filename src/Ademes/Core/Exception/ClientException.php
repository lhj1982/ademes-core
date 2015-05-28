<?php
namespace Ademes\Core\Exception;

use Ademes\Core\Exception\CoreException as CoreException;

class ClientException extends CoreException {

	public function __construct($code, $message) {
	    $this->httpStatusCode = $code;
	    $this->errorType = 'client_error';
        parent::__construct($message);
    }
}
?>