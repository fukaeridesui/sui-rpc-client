<?php

namespace Fukaeridesui\SuiRpcClient\Api;

use Fukaeridesui\SuiRpcClient\Interface\CoinQueryApiInterface;
use Fukaeridesui\SuiRpcClient\Interface\HttpClientInterface;
use Fukaeridesui\SuiRpcClient\Responses\Coin\BalanceResponse;
use Fukaeridesui\SuiRpcClient\Exception\SuiRpcException;

class CoinQueryApi implements CoinQueryApiInterface
{
    private HttpClientInterface $httpClient;

    /**
     * @param HttpClientInterface $httpClient HTTP client
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllBalances(string $owner): array
    {
        $result = $this->httpClient->request('suix_getAllBalances', [$owner]);

        if (!is_array($result)) {
            throw new SuiRpcException(null, 'Invalid response: Expected array of balances');
        }

        $balances = [];
        foreach ($result as $balance) {
            $balances[] = new BalanceResponse($balance);
        }

        return $balances;
    }
}
