<?php

namespace App\Models;

use Laravel\Cashier\SubscriptionItem as CashierSubscriptionItem;

class SubscriptionItem extends CashierSubscriptionItem
{
    /**
     * Get the subscription that the item belongs to.
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
