<?php

namespace ApiBundle\Exceptions;

/**
 * Class UnprocessableEntityException
 * @package ApiBundle\Exceptions
 */
class UnprocessableEntityException extends ApiBaseException {

    /**
     * @var string
     */
    public $errorTypeMessage = self::EXCEPTION_MESSAGE_TYPE_BASE . 'unprocessable_entity';

    public function __construct($messageKey = "", array $messageParameters = [], $code = 422) {
        parent::__construct($messageKey, $messageParameters, $code);
    }

}