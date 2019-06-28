<?php
namespace modules\sitemodule;

use Monolog\Processor\ProcessorInterface;
use Ramsey\Uuid\UuidFactory;

class RequestIdProcessor implements ProcessorInterface
{
    private $requestId;

    public function __construct()
    {
        if (isset($_SERVER['HTTP_X_REQUEST_ID'])) {
            $this->requestId = $_SERVER["HTTP_X_REQUEST_ID"];
        } else {
            $factory = new UuidFactory();
            $this->requestId = $factory->uuid4()->toString();
        }
    }

    public function __invoke(array $record): array
    {
        if (!isset($record['context'])) {
            $record['context'] = [];
        }

        $record['context']['request_id'] = $this->requestId;
        return $record;
    }

    public function getRequestId(): string
    {
        return $this->requestId;
    }
}
