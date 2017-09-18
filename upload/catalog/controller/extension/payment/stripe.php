<?php
class ControllerExtensionPaymentStripe extends Controller {
	public function index() {
		$this->load->language('extension/payment/stripe');
		$this->load->model('extension/payment/stripe');

		if($this->config->get('stripe_environment') == 'live') {
			$data['publishable_key'] = $this->config->get('stripe_live_publishable_key');
		} else {
			$data['publishable_key'] = $this->config->get('stripe_test_publishable_key');
		}

		$data['text_credit_card'] = $this->language->get('text_credit_card');
		$data['text_start_date'] = $this->language->get('text_start_date');
		$data['text_wait'] = $this->language->get('text_wait');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['entry_cc_type'] = $this->language->get('entry_cc_type');
		$data['entry_cc_number'] = $this->language->get('entry_cc_number');
		$data['entry_cc_start_date'] = $this->language->get('entry_cc_start_date');
		$data['entry_cc_expire_date'] = $this->language->get('entry_cc_expire_date');
		$data['entry_cc_cvv2'] = $this->language->get('entry_cc_cvv2');
		$data['entry_cc_issue'] = $this->language->get('entry_cc_issue');

		$data['help_start_date'] = $this->language->get('help_start_date');
		$data['help_issue'] = $this->language->get('help_issue');

		$data['button_confirm'] = $this->language->get('button_confirm');

		$data['can_store_cards'] = ($this->customer->isLogged() && $this->config->get('stripe_store_cards'));
		$data['cards'] = [];

		if($this->customer->isLogged() && $this->config->get('stripe_store_cards')) {
			$data['cards'] = $this->model_extension_payment_stripe->getCards($this->customer->getId());
		}

		return $this->load->view('extension/payment/stripe', $data);
	}

	public function send() {
		$json = array();

		$this->load->library('stripe');
		$this->load->model('checkout/order');
		$this->load->model('account/customer');
		$this->load->model('extension/payment/stripe');

		$stripe_environment = $this->config->get('stripe_environment');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);


		if($this->initStripe()) {
			$use_existing_card = json_decode($this->request->post['existingCard']);

			$stripe_customer_id = '';
			$stripe_charge_parameters = array(
				'amount' => $order_info['total'] * 100,
				'currency' => $this->config->get('stripe_currency'),
				'metadata' => array(
					'orderId' => $this->session->data['order_id']
				)
			);

			# If customer is logged, but isn't registered as a customer in Stripe
			if($this->customer->isLogged() && !$this->model_extension_payment_stripe->getCustomer($this->customer->getId())) {
				$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());

				$stripe_customer = \Stripe\Customer::create(array(
					'email' => $customer_info['email'],
					'metadata' => array(
						'customerId' => $this->customer->getId()
					)
				));

				$this->model_extension_payment_stripe->addCustomer(
					$stripe_customer,
					$this->customer->getId(),
					$stripe_environment
				);

			}

			# If customer exists we use it
			$stripe_customer = $this->model_extension_payment_stripe->getCustomer($this->customer->getId());


			# May be the customer want to save its credit card
			if($stripe_customer && ($use_existing_card == false)) {
				$stripe_charge_parameters['customer'] = $stripe_customer['stripe_customer_id'];
				$customer = \Stripe\Customer::retrieve($stripe_customer['stripe_customer_id']);
				$stripe_card = $customer->sources->create(array("source" => $this->request->post['card']));
				$stripe_charge_parameters['customer'] = $customer['id'];
				$stripe_charge_parameters['source'] = $stripe_card['id'];

				if(!!json_decode($this->request->post['saveCreditCard'])) {
					$this->model_extension_payment_stripe->addCard(
						$stripe_card,
						$this->customer->getId(),
						$stripe_environment
					);
				}
			} else {
				$stripe_charge_parameters['source'] = $this->request->post['card'];
			}

			if($use_existing_card && $stripe_customer) {
				$stripe_charge_parameters['customer'] = $stripe_customer['stripe_customer_id'];
			}

			$charge = \Stripe\Charge::create($stripe_charge_parameters);

			if(!json_decode($this->request->post['saveCreditCard']) && isset($customer) && isset($stripe_card)) {
				$customer->sources->retrieve($stripe_card['id'])->delete();
			}

			if(isset($charge['id'])) {
				$this->model_extension_payment_stripe->addOrder($order_info, $charge['id'], $stripe_environment);
				$message = 'Charge ID: '.$charge['id'].' Status:'. $charge['status'];
				$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('stripe_order_status_id'), $message, false);
				$json['processed'] = true;
			}


			// addOrderHistory
			$json['success'] = $this->url->link('checkout/success');
			// $json['error'] = $response_info['L_LONGMESSAGE0'];
		} else {
			$json['error'] = 'Contact administrator';
		}
		

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	private function initStripe() {
		$this->load->library('stripe');
		if($this->config->get('stripe_environment') == 'live') {
			$stripe_secret_key = $this->config->get('stripe_live_secret_key');
		} else {
			$stripe_secret_key = $this->config->get('stripe_test_secret_key');
		}

		if($stripe_secret_key != '' && $stripe_secret_key != null) {
			\Stripe\Stripe::setApiKey($stripe_secret_key);
			return true;
		}

		return false;

	}
}
