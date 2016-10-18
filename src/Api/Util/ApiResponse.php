<?php
declare (strict_types = 1);

namespace BenHx\Api\Util;

use Slim\Http\Response;

class ApiResponse extends Response
{
    public function withClosure(\Closure $closure) {
        return $this->withData($closure());
    }

    public function withApiSerializeable(ApiSerializeable $serializeable) {
        return $this->withData($serializeable);
    }

    public function withException(\Exception $exception) {
        $result = [];
        $result['success'] = $this->isSuccessful();
        $result['error']['code'] = $exception->getCode();
        $result['error']['message'] = $exception->getMessage();
        $body = $this->getBody();
        $body->rewind();
        $body->write($json = json_encode($result));

        // Ensure that the json encoding passed successfully
        if ($json === false) {
            throw new \RuntimeException(json_last_error_msg(), json_last_error());
        }
        $clone = clone $this;
        return $clone;
    }

    private function withData($data) {
        $result = [];
        $result['success'] = $this->isSuccessful();
        $result['data'] = $data;
        $body = $this->getBody();
        $body->rewind();
        $body->write($json = json_encode($result));

        // Ensure that the json encoding passed successfully
        if ($json === false) {
            throw new \RuntimeException(json_last_error_msg(), json_last_error());
        }
        $clone = clone $this;
        return $clone;
    }

}