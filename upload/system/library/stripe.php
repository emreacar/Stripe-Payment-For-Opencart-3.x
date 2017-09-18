<?php

// Stripe singleton
require_once(DIR_SYSTEM.'library/stripe-php/Stripe.php');

// Utilities
require_once(DIR_SYSTEM.'library/stripe-php/Util/AutoPagingIterator.php');
require_once(DIR_SYSTEM.'library/stripe-php/Util/RequestOptions.php');
require_once(DIR_SYSTEM.'library/stripe-php/Util/Set.php');
require_once(DIR_SYSTEM.'library/stripe-php/Util/Util.php');

// HttpClient
require_once(DIR_SYSTEM.'library/stripe-php/HttpClient/ClientInterface.php');
require_once(DIR_SYSTEM.'library/stripe-php/HttpClient/CurlClient.php');

// Errors
require_once(DIR_SYSTEM.'library/stripe-php/Error/Base.php');
require_once(DIR_SYSTEM.'library/stripe-php/Error/Api.php');
require_once(DIR_SYSTEM.'library/stripe-php/Error/ApiConnection.php');
require_once(DIR_SYSTEM.'library/stripe-php/Error/Authentication.php');
require_once(DIR_SYSTEM.'library/stripe-php/Error/Card.php');
require_once(DIR_SYSTEM.'library/stripe-php/Error/InvalidRequest.php');
require_once(DIR_SYSTEM.'library/stripe-php/Error/RateLimit.php');

// Plumbing
require_once(DIR_SYSTEM.'library/stripe-php/ApiResponse.php');
require_once(DIR_SYSTEM.'library/stripe-php/JsonSerializable.php');
require_once(DIR_SYSTEM.'library/stripe-php/StripeObject.php');
require_once(DIR_SYSTEM.'library/stripe-php/ApiRequestor.php');
require_once(DIR_SYSTEM.'library/stripe-php/ApiResource.php');
require_once(DIR_SYSTEM.'library/stripe-php/SingletonApiResource.php');
require_once(DIR_SYSTEM.'library/stripe-php/AttachedObject.php');
require_once(DIR_SYSTEM.'library/stripe-php/ExternalAccount.php');

// Stripe API Resources
require_once(DIR_SYSTEM.'library/stripe-php/Account.php');
require_once(DIR_SYSTEM.'library/stripe-php/AlipayAccount.php');
require_once(DIR_SYSTEM.'library/stripe-php/ApplicationFee.php');
require_once(DIR_SYSTEM.'library/stripe-php/ApplicationFeeRefund.php');
require_once(DIR_SYSTEM.'library/stripe-php/Balance.php');
require_once(DIR_SYSTEM.'library/stripe-php/BalanceTransaction.php');
require_once(DIR_SYSTEM.'library/stripe-php/BankAccount.php');
require_once(DIR_SYSTEM.'library/stripe-php/BitcoinReceiver.php');
require_once(DIR_SYSTEM.'library/stripe-php/BitcoinTransaction.php');
require_once(DIR_SYSTEM.'library/stripe-php/Card.php');
require_once(DIR_SYSTEM.'library/stripe-php/Charge.php');
require_once(DIR_SYSTEM.'library/stripe-php/Collection.php');
require_once(DIR_SYSTEM.'library/stripe-php/CountrySpec.php');
require_once(DIR_SYSTEM.'library/stripe-php/Coupon.php');
require_once(DIR_SYSTEM.'library/stripe-php/Customer.php');
require_once(DIR_SYSTEM.'library/stripe-php/Dispute.php');
require_once(DIR_SYSTEM.'library/stripe-php/Event.php');
require_once(DIR_SYSTEM.'library/stripe-php/FileUpload.php');
require_once(DIR_SYSTEM.'library/stripe-php/Invoice.php');
require_once(DIR_SYSTEM.'library/stripe-php/InvoiceItem.php');
require_once(DIR_SYSTEM.'library/stripe-php/Order.php');
require_once(DIR_SYSTEM.'library/stripe-php/OrderReturn.php');
require_once(DIR_SYSTEM.'library/stripe-php/Plan.php');
require_once(DIR_SYSTEM.'library/stripe-php/Product.php');
require_once(DIR_SYSTEM.'library/stripe-php/Recipient.php');
require_once(DIR_SYSTEM.'library/stripe-php/Refund.php');
require_once(DIR_SYSTEM.'library/stripe-php/SKU.php');
require_once(DIR_SYSTEM.'library/stripe-php/Source.php');
require_once(DIR_SYSTEM.'library/stripe-php/Subscription.php');
require_once(DIR_SYSTEM.'library/stripe-php/ThreeDSecure.php');
require_once(DIR_SYSTEM.'library/stripe-php/Token.php');
require_once(DIR_SYSTEM.'library/stripe-php/Transfer.php');
require_once(DIR_SYSTEM.'library/stripe-php/TransferReversal.php');

class Stripe {
    
}
