<?php

namespace Fukaeridesui\SuiRpcClient\Interface;

use Psr\Http\Client\ClientInterface;

interface HttpClientInterface
{
    /**
     * Send a JSON-RPC request
     * 
     * @param string $method RPC method name
     * @param array $params RPC parameters
     * @return mixed RPC response result
     */
    public function request(string $method, array $params = []): mixed;

    /**
     * Get RPC URL
     * 
     * @return string RPC URL
     */
    public function getRpcUrl(): string;

    /**
     * Get PSR-18 HTTP client
     * 
     * @return ClientInterface|null PSR-18 HTTP client
     */
    public function getPsrClient(): ?ClientInterface;
}
