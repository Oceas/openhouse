# Stripe Subscription Setup Guide

## Overview
Your Open House application now has a complete subscription system with:
- $9.99/month pricing
- 14-day free trial for all new users
- Secure Stripe integration via Laravel Cashier

## Required Steps to Complete Setup

### 1. Create Stripe Account & Get API Keys
1. Go to [Stripe Dashboard](https://dashboard.stripe.com)
2. Create account or log in
3. In test mode, go to **Developers > API Keys**
4. Copy your **Publishable key** and **Secret key**

### 2. Create Product & Price in Stripe
1. In Stripe Dashboard, go to **Products**
2. Click **+ Add product**
3. Set name: "Open House Professional"
4. Set description: "Full access to Open House property management platform"
5. Set pricing model: **Recurring**
6. Set price: **$9.99 USD monthly**
7. Copy the **Price ID** (starts with `price_`)

### 3. Set Environment Variables
Create a `.env` file in your project root with:

```env
# App Configuration
APP_NAME="Open House"
APP_ENV=local
APP_KEY=your_app_key_here
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

# Database
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/your/database.sqlite

# Stripe Configuration
STRIPE_KEY=pk_test_your_publishable_key_here
STRIPE_SECRET=sk_test_your_secret_key_here
STRIPE_PRICE_ID=price_your_price_id_here

# Optional: Webhook endpoint (for production)
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret_here
```

### 4. Test the Integration
1. Start your Laravel server: `php artisan serve`
2. Register a new user or log in
3. Go to `/subscription` to see the pricing page
4. Use Stripe test cards:
   - Success: `4242 4242 4242 4242`
   - Decline: `4000 0000 0000 0002`

## Features Implemented

### ✅ User Experience
- **Trial Period**: All new users get 14 days free
- **Subscription Required**: Access blocked after trial expires
- **Seamless Checkout**: Stripe-hosted checkout pages
- **Billing Portal**: Users can manage their own billing

### ✅ Developer Features
- **Middleware Protection**: Routes automatically protected
- **Trial Management**: Built-in trial tracking and expiration
- **Subscription Status**: Dashboard shows current status
- **Billing Integration**: Complete subscription lifecycle management

### ✅ Admin Features
- **User Management**: See trial/subscription status
- **Revenue Tracking**: Via Stripe Dashboard
- **Webhook Support**: Ready for production webhooks

## File Structure
```
app/Http/Controllers/SubscriptionController.php  # Subscription logic
app/Http/Middleware/EnsureUserHasAccess.php      # Access control
app/Models/User.php                              # Billable trait added
resources/views/subscription/                    # Subscription views
routes/web.php                                   # Subscription routes
config/services.php                              # Stripe configuration
```

## Production Checklist
- [ ] Switch to live Stripe keys
- [ ] Set up webhook endpoint
- [ ] Configure proper domain in Stripe
- [ ] Test subscription flows
- [ ] Set up monitoring and alerts

## Support
- [Laravel Cashier Documentation](https://laravel.com/docs/billing)
- [Stripe Documentation](https://stripe.com/docs)
- [Stripe Test Cards](https://stripe.com/docs/testing)
