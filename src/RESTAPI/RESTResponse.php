<?php

declare(strict_types=1);

namespace PHPUnitForGraphQLAPI\GraphQLAPITesting\RESTAPI;

use Psr\Http\Message\ResponseInterface;
use stdClass;

class RESTResponse
{
    /**
     * @var string
     */
    public $status = '';
    /**
     * @var string
     */
    public $message = '';
    /**
     * @var \stdClass
     */
    public $data;
    public function __construct(string $status = '', string $message = '', stdClass $data = null)
    {
        $data = $data ?? new stdClass();
        $this->status = $status;
        $this->message = $message;
        /**
         * Extra data
         */
        $this->data = $data;
    }
    /**
     * @param \Psr\Http\Message\ResponseInterface $clientResponse
     */
    public static function fromClientResponse($clientResponse): self
    {
        $clientResponseContents = json_decode($clientResponse->getBody()->__toString());
        $restResponse = new self();
        $restResponse->status = $clientResponseContents->status;
        $restResponse->message = $clientResponseContents->message;
        $restResponse->data = (object) $clientResponseContents->data;
        return $restResponse;
    }
}
