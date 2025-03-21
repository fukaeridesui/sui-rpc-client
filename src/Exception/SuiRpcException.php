<?php

namespace Fukaeridesui\SuiRpcClient\Exception;

/**
 * Sui RPC Exception
 */
class SuiRpcException extends \Exception
{
    /**
     * @var array|null JSON-RPC Error Information
     */
    private ?array $rpcError;

    /**
     * @param array|null $error JSON-RPC Error Information
     * @param string|null $message Error Message
     * @param int $code Error Code
     * @param \Throwable|null $previous Previous Exception
     */
    public function __construct(?array $error = null, ?string $message = null, int $code = 0, ?\Throwable $previous = null)
    {
        $this->rpcError = $error;

        if ($message === null && $error !== null) {
            $message = "RPC Error: " . json_encode($error, JSON_UNESCAPED_UNICODE);
        } elseif ($message === null) {
            $message = "Unknown RPC Error";
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * Get JSON-RPC Error Information
     * 
     * @return array|null
     */
    public function getRpcError(): ?array
    {
        return $this->rpcError;
    }
}
