<?php

namespace App\Events;

use App\Models\Account;
use Illuminate\Queue\SerializesModels;

class UserAccountDeleted
{
    use SerializesModels;

    public Account $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }
}
