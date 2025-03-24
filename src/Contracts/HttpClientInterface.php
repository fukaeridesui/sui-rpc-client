<?php

namespace Fukaeridesui\SuiRpcClient\Contracts;

use Psr\Http\Client\ClientInterface;

interface HttpClientInterface
{
    /**
     * Execute JSON-RPC request
     *
     * @param string $method RPC method name
     * @param array $params RPC parameters
     * @return array Response result
     * @throws \Fukaeridesui\SuiRpcClient\Exception\SuiRpcException
     */
    public function request(string $method, array $params = []): array;

    /**
     * Get RPC URL
     *
     * @return string RPC URL
     */
    public function getRpcUrl(): string;

    /**
     * Get underlying PSR-18 HTTP client
     *
     * @return ClientInterface|null The PSR-18 client (if available)
     */
    public function getPsrClient(): ?ClientInterface;
}
