<?php
namespace App\Library
{
	use Session;
	use URL;
	use Stripe\Error\Card;
	use Cartalyst\Stripe\Stripe;
	use net\authorize\api\contract\v1 as AnetAPI;
	use net\authorize\api\controller as AnetController;
	use PayPal\Api\Amount;
	use PayPal\Api\Details;
	use PayPal\Api\Item;
	use PayPal\Api\ItemList;
	use PayPal\Api\Payer;
	use PayPal\Api\Payment;
	use PayPal\Api\RedirectUrls;
	use PayPal\Api\Transaction;
	use PayPal\Api\PaymentExecution;
	
	class paymentlib
	{
	    public static function stripePayment($input)
		{
			$input = array_except($input,array('_token'));
        	$stripe = Stripe::make('sk_test_zz44Jz5elsthGIItc9Wq2ZT4');
        	try {
				$token = $stripe->tokens()->create([
					'card' => [
				  		'number' => $input['cc_number'],
				  		'exp_month' => $input['cc_expire_month'],
				  		'exp_year' => $input['cc_expire_year'],
				  		'cvc' => $input['cc_code'],
				  	],
				]);
         
				if (!isset($token['id'])) {
					return redirect()->back();
				}

          		$paymentResponse = $stripe->charges()->create([
            		'card' => $token['id'],
            		'currency' => 'USD',
            		'amount' => $input['cc_amount'],
            		'description' => 'Donation Add in Wallet',
          		]);
          
           		if($paymentResponse['status'] == 'succeeded') {
					$returnData['error'] = false;
					$returnData['message'] = 'Payment Successful !';
					$returnData['data'] = array('transaction_id'=>$paymentResponse['balance_transaction']);
           		} 
           		else {
           			$returnData['error'] = true;
					$returnData['message'] = 'Money not add in wallet !';
            	}
          	} 
          	catch (Exception $e) {
				$returnData['error'] = true;
				$returnData['message'] = $e->getMessage();
			} 
			catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
				$returnData['error'] = true;
				$returnData['message'] = $e->getMessage();
			} 
			catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
				$returnData['error'] = true;
				$returnData['message'] = $e->getMessage();
			}
			return $returnData;
		}

		public static function authoraizePayment($input)
		{
			$merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
			$merchantAuthentication->setName(config('services.authorize.login'));
			$merchantAuthentication->setTransactionKey(config('services.authorize.key'));
			$refId = 'ref'.time();
			$creditCard = new AnetAPI\CreditCardType();
			$creditCard->setCardNumber($input['cc_number']);
			$creditCard->setExpirationDate( $input['cc_expire_year']."-".$input['cc_expire_month']);
			$creditCard->setCardCode($input['cc_code']);
			$paymentOne = new AnetAPI\PaymentType();
			$paymentOne->setCreditCard($creditCard);
			$order = new AnetAPI\OrderType();
			$order->setInvoiceNumber("10101");
			$order->setDescription("Donation");  
			$customerAddress = new AnetAPI\CustomerAddressType();
			$customerAddress->setFirstName($input['first_name']);
			$customerAddress->setLastName($input['last_name']);
			$customerAddress->setCompany("Souveniropolis");
			$customerAddress->setAddress($input['address_1']);
			$customerAddress->setCity($input['city']);
			$customerAddress->setState($input['state']);
			$customerAddress->setZip($input['zip_code']);
			$customerAddress->setCountry('usa');
			$customerData = new AnetAPI\CustomerDataType();
			$customerData->setType("individual");
			$customerData->setId("99999456654");
			$customerData->setEmail($input['email']);  
			$duplicateWindowSetting = new AnetAPI\SettingType();
			$duplicateWindowSetting->setSettingName("duplicateWindow");
			$duplicateWindowSetting->setSettingValue("60");  
			$merchantDefinedField1 = new AnetAPI\UserFieldType();
			$merchantDefinedField1->setName("customerLoyaltyNum");
			$merchantDefinedField1->setValue("1128836273");  
			$merchantDefinedField2 = new AnetAPI\UserFieldType();
			$merchantDefinedField2->setName("favoriteColor");
			$merchantDefinedField2->setValue("blue");
			$transactionRequestType = new AnetAPI\TransactionRequestType();
			$transactionRequestType->setTransactionType("authCaptureTransaction");
			$transactionRequestType->setAmount($input['cc_amount']);
			$transactionRequestType->setOrder($order);
			$transactionRequestType->setPayment($paymentOne);
			$transactionRequestType->setBillTo($customerAddress);
			$transactionRequestType->setCustomer($customerData);
			$transactionRequestType->addToTransactionSettings($duplicateWindowSetting);
			$transactionRequestType->addToUserFields($merchantDefinedField1);
			$transactionRequestType->addToUserFields($merchantDefinedField2);
			$request = new AnetAPI\CreateTransactionRequest();
			$request->setMerchantAuthentication($merchantAuthentication);
			$request->setRefId($refId);
			$request->setTransactionRequest($transactionRequestType);
			$controller = new AnetController\CreateTransactionController($request);
			$response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

			if ($response != null) {
				if ($response->getMessages()->getResultCode() == "Ok") {
				    $tresponse = $response->getTransactionResponse();
				    if ($tresponse != null && $tresponse->getMessages() != null) {
				        $returnData['error'] = false;
						$returnData['message'] = 'Authorize Payment Successful !';
						$returnData['data'] = array('transaction_id'=>$tresponse->getTransId());
				    }else{
						if ($tresponse->getErrors() != null) {
							$returnData['error'] = true;
							$returnData['message'] = 'Authorize Transaction Failed. '.$tresponse->getErrors()[0]->getErrorText();
						}
				    }
				} 
				else {
					$tresponse = $response->getTransactionResponse();
					if ($tresponse != null && $tresponse->getErrors() != null) {
						$returnData['error'] = true;
						$returnData['message'] = 'Authorize Transaction Failed. '.$tresponse->getErrors()[0]->getErrorText();
					}
					else 
					{
						$returnData['error'] = true;
						$returnData['message'] = 'Authorize Transaction Failed. '.$response->getMessages()->getMessage()[0]->getText();
					}
				}
			} 
			else 
			{
				$returnData['error'] = true;
				$returnData['message'] = 'No response returned';
			}
			return $returnData; 
		}

		public static function paypalApiContext()
	  	{
	    	$apiContext = new \PayPal\Rest\ApiContext(
	                    new \PayPal\Auth\OAuthTokenCredential(
	                      // ClientID
	                      'AUrkzXKfIBoJu-puo1zBWYyUWyROy9u-Q9X7v0Q4dtEUv0uMnDF34VLe49wxU39VhqCovR_c57gk1f2c',
	                      // ClientSecret     
	                      'ECXkha0OnEY5dm6_44GIQkfAHLPQFxh-BuZYcFXHg7jJZPvxUItUzGW0nVecs-praOPe9ab3h5YTUu9R'      
	                    )
	                  );
	    	return $apiContext;
	  	}

	  	public static function paypalPayment($input)
		{
			session(['InputSession' => $input]);

			$apiContext = self::paypalApiContext();
		    $payer = new Payer();
		    $payer->setPaymentMethod("paypal");

		    $allItems =array();
		    $item1 = new Item();
		    $item1->setName('Donation')
		          ->setCurrency('USD')
		          ->setQuantity(1)
		          ->setSku("123123")
		          ->setPrice($input['cc_amount']);
		    $allItems['item1']= $item1; 
		    $itemList = new ItemList();
		    $itemList->setItems($allItems);

		    $details = new Details();
		    $details->setShipping(0)
		            ->setTax(0)
		            ->setSubtotal($input['cc_amount']);

		    $amount = new Amount();
		    $amount->setCurrency("USD")
		        ->setTotal($input['cc_amount'])
		        ->setDetails($details);

		    $transaction = new Transaction();
		    $transaction->setAmount($amount)
		                ->setItemList($itemList)
		                ->setDescription("Payment description")
		                ->setInvoiceNumber(uniqid());


		    $redirectUrls = new RedirectUrls();
		    $redirectUrls->setReturnUrl(URL::to('get-paypal-payment-status')) // Return Url
		        ->setCancelUrl(URL::to('get-paypal-payment-status')); // Cancel Url

		    $payment = new Payment();
		    $payment->setIntent("sale")
		            ->setPayer($payer)
		            ->setRedirectUrls($redirectUrls)
		            ->setTransactions(array($transaction));

		    try {
		      	$payment->create($apiContext);
		    } catch (Exception $ex) {
		    	$returnData['error'] = true;
				$returnData['message'] = 'Technical error in creating Payment';
				return $returnData;
		    }

		    foreach ($payment->getLinks() as $link) {
		      if ($link->getRel() == 'approval_url') {
		          $redirect_url = $link->getHref();
		          break;
		      }
		    }

		    Session::put('paypal_payment_id', $payment->getId());
		    if (isset($redirect_url)) {
		    	$returnData['error'] = false;
				$returnData['data'] = array('redirect_url'=>$redirect_url);
				return $returnData;
		    }

		    $returnData['error'] = true;
			$returnData['message'] = 'Unknown error occurred !';
			return $returnData;
		}

		public static function PaypalPaymentGetStatusAndStoreData($resonse_data)
		{
			$payment_id = Session::get('paypal_payment_id');
			
			if (empty($resonse_data['PayerID']) || empty($resonse_data['token'])) {
				$returnData['error'] = true;
				$returnData['message'] = 'Paypal Payment has been Cancelled !';
				return $returnData;
			}
			$payment = Payment::get($payment_id, self::paypalApiContext());
			$execution = new PaymentExecution();
			$execution->setPayerId($resonse_data['PayerID']);
			$result = $payment->execute($execution, self::paypalApiContext());

			if ($result->getState() == 'approved') {
				Session::forget('paypal_payment_id');
				$returnData['error'] = false;
				$returnData['message'] = 'Paypal Payment Successful !';
				$returnData['data'] = array('transaction_id'=>$result->getId());
			}else{
				$returnData['error'] = true;
				$returnData['message'] = 'Paypal Payment Failed !';
			}
			return $returnData;
		}
	}
}