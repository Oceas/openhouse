<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Illuminate\Support\Facades\Log;

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
        Log::info('Webhook: customer.subscription.created received', [
            'customer_id' => $payload['data']['object']['customer'],
            'subscription_id' => $payload['data']['object']['id'],
            'status' => $payload['data']['object']['status']
        ]);

        $user = $this->getUserByStripeId($payload['data']['object']['customer']);

        if ($user) {
            Log::info('Webhook: User found for customer', ['user_id' => $user->id, 'user_email' => $user->email]);
            
            $data = $payload['data']['object'];

            try {
                // Create the subscription
                $subscription = $user->subscriptions()->create([
                    'type' => 'default',
                    'stripe_id' => $data['id'],
                    'stripe_status' => $data['status'],
                    'stripe_price' => $data['items']['data'][0]['price']['id'],
                    'quantity' => $data['items']['data'][0]['quantity'],
                    'trial_ends_at' => isset($data['trial_end']) ? date('Y-m-d H:i:s', $data['trial_end']) : null,
                    'ends_at' => isset($data['ended_at']) ? date('Y-m-d H:i:s', $data['ended_at']) : null,
                ]);

                Log::info('Webhook: Subscription created successfully', [
                    'subscription_id' => $subscription->id,
                    'stripe_id' => $subscription->stripe_id
                ]);

                // Create subscription items
                foreach ($data['items']['data'] as $item) {
                    $subscription->items()->create([
                        'stripe_id' => $item['id'],
                        'stripe_product' => $item['price']['product'],
                        'stripe_price' => $item['price']['id'],
                        'quantity' => $item['quantity'],
                    ]);

                    Log::info('Webhook: Subscription item created', [
                        'item_id' => $item['id'],
                        'product' => $item['price']['product']
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Webhook: Failed to create subscription', [
                    'error' => $e->getMessage(),
                    'user_id' => $user->id,
                    'stripe_id' => $data['id']
                ]);
                throw $e;
            }
        } else {
            Log::warning('Webhook: No user found for customer', ['customer_id' => $payload['data']['object']['customer']]);
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
        Log::info('Webhook: customer.subscription.updated received', [
            'customer_id' => $payload['data']['object']['customer'],
            'subscription_id' => $payload['data']['object']['id'],
            'status' => $payload['data']['object']['status']
        ]);

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

                Log::info('Webhook: Subscription updated successfully', [
                    'subscription_id' => $subscription->id,
                    'stripe_id' => $subscription->stripe_id
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
        Log::info('Webhook: customer.subscription.deleted received', [
            'customer_id' => $payload['data']['object']['customer'],
            'subscription_id' => $payload['data']['object']['id']
        ]);

        $user = $this->getUserByStripeId($payload['data']['object']['customer']);

        if ($user) {
            $data = $payload['data']['object'];

            $subscription = $user->subscriptions()->where('stripe_id', $data['id'])->first();

            if ($subscription) {
                $subscription->markAsCancelled();
                Log::info('Webhook: Subscription marked as cancelled', [
                    'subscription_id' => $subscription->id,
                    'stripe_id' => $subscription->stripe_id
                ]);
            }
        }

        return $this->successMethod();
    }
}
