<?php

namespace Fukaeridesui\SuiRpcClient\Exception;

/**
 * Sui RPC エラー例外
 */
class SuiRpcException extends \Exception
{
    /**
     * @var array|null JSON-RPCエラー情報
     */
    private ?array $rpcError;

    /**
     * @param array|null $error JSON-RPCエラー情報
     * @param string|null $message エラーメッセージ
     * @param int $code エラーコード
     * @param \Throwable|null $previous 前の例外
     */
    public function __construct(?array $error = null, ?string $message = null, int $code = 0, \Throwable $previous = null)
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
     * JSON-RPCエラー情報を取得
     * 
     * @return array|null
     */
    public function getRpcError(): ?array
    {
        return $this->rpcError;
    }
}
