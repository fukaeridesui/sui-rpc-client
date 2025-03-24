flowchart TD
    subgraph Client
        SuiRpcClient
    end

    subgraph APIs
        ReadApi
        CoinQueryApi
    end

    subgraph Interfaces
        ReadApiInterface
        CoinQueryApiInterface
        HttpClientInterface
        ObjectResponseInterface
    end

    subgraph HTTPClients
        GuzzleHttpClient
        Psr18HttpClient
    end

    subgraph Options
        BaseOptions --> PaginationOptions
        PaginationOptions --> GetAllCoinsOptions
        PaginationOptions --> GetCoinsOptions
        BaseOptions --> GetBalanceOptions
        BaseOptions --> GetCoinMetadataOptions
        BaseOptions --> GetObjectOptions
    end

    subgraph Responses["Responses"]
        subgraph ReadResponses["Read Responses"]
            GetObjectResponse
            MultipleObjectsResponse
        end
        
        subgraph CoinResponses["Coin Responses"]
            BalanceResponse
            CoinMetadataResponse
            GetAllCoinsResponse
            CoinObjectResponse
        end
    end

    subgraph Exceptions
        SuiRpcException
    end

    SuiRpcClient --> ReadApi
    SuiRpcClient --> CoinQueryApi
    SuiRpcClient --> GuzzleHttpClient
    SuiRpcClient -.-> Psr18HttpClient

    ReadApi --> GetObjectResponse
    ReadApi --> MultipleObjectsResponse
    ReadApi -.-> SuiRpcException
    
    CoinQueryApi --> BalanceResponse
    CoinQueryApi --> CoinMetadataResponse
    CoinQueryApi --> GetAllCoinsResponse
    CoinQueryApi -.-> SuiRpcException
    
    GetAllCoinsResponse --> CoinObjectResponse
    
    ReadApi --> ReadApiInterface
    CoinQueryApi --> CoinQueryApiInterface
    GuzzleHttpClient --> HttpClientInterface
    Psr18HttpClient --> HttpClientInterface
    GetObjectResponse --> ObjectResponseInterface