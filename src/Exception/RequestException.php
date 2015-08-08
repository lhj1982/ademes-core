<?php
namespace Ademes\Core\Exception;

use Ademes\Core\Exception\CoreException as CoreException;
class RequestException extends CoreException {

	public function __construct($message) {
	    $this->httpStatusCode = 400;
	    $this->errorType = 'bad_request';
        parent::__construct($message);
    }
}
?>