<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
    /**
     * Handle customer subscription created.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleCustomerSubscriptionCreated(array $payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);

        if ($user) {
            $data = $payload['data']['object'];

            // Create the subscription
            $user->subscriptions()->create([
                'name' => 'default',
                'stripe_id' => $data['id'],
                'stripe_status' => $data['status'],
                'stripe_price' => $data['items']['data'][0]['price']['id'],
                'quantity' => $data['items']['data'][0]['quantity'],
                'trial_ends_at' => isset($data['trial_end']) ? date('Y-m-d H:i:s', $data['trial_end']) : null,
                'ends_at' => isset($data['ended_at']) ? date('Y-m-d H:i:s', $data['ended_at']) : null,
            ]);
        }

        return $this->successMethod();
    }

    /**
     * Handle customer subscription updated.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleCustomerSubscriptionUpdated(array $payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);

        if ($user) {
            $data = $payload['data']['object'];

            $subscription = $user->subscriptions()->where('stripe_id', $data['id'])->first();

            if ($subscription) {
                $subscription->update([
                    'stripe_status' => $data['status'],
                    'stripe_price' => $data['items']['data'][0]['price']['id'],
                    'quantity' => $data['items']['data'][0]['quantity'],
                    'trial_ends_at' => isset($data['trial_end']) ? date('Y-m-d H:i:s', $data['trial_end']) : null,
                    'ends_at' => isset($data['ended_at']) ? date('Y-m-d H:i:s', $data['ended_at']) : null,
                ]);
            }
        }

        return $this->successMethod();
    }

    /**
     * Handle customer subscription deleted.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleCustomerSubscriptionDeleted(array $payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);

        if ($user) {
            $data = $payload['data']['object'];

            $subscription = $user->subscriptions()->where('stripe_id', $data['id'])->first();

            if ($subscription) {
                $subscription->markAsCancelled();
            }
        }

        return $this->successMethod();
    }
}
