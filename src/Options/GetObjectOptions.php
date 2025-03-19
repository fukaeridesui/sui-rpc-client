<?php

namespace Fukaeridesui\SuiRpcClient\Options;

class GetObjectOptions extends BaseOptions
{
    public bool $showType = true;
    public bool $showOwner = true;
    public bool $showPreviousTransaction = false;
    public bool $showDisplay = false;
    public bool $showContent = true;
    public bool $showBcs = false;
    public bool $showStorageRebate = false;
}
