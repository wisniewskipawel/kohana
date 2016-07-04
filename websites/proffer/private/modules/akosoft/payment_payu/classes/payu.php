<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2015, AkoSoft
*/
class PayU {

	const STATUS_FAILED     = -1;
	const STATUS_PENDING    = 0;
	const STATUS_SUCCESS    = 1;

	public $config = array();

	public $response = array();

	public $type = NULL;
	public $provider = NULL;

	protected $fields = array();

	public function __construct($provider)
	{
		$this->provider = $provider;
		$this->type = $this->provider->get_name();

		$this->config = Kohana::$config->load('global.payment.'.$this->provider->get_config_path(FALSE));

		if(!$this->config)
		{
			throw new Kohana_Exception('Configure PayU payments before this action!');
		}

		$this->config = Arr::merge(
			Kohana::$config->load('payu')->get($this->type),
			$this->config
		);

		if(empty($this->config['pos_id'])
			|| empty($this->config['pos_auth_key'])
			|| empty($this->config['key'])
			|| empty($this->config['key2']))
		{
			throw new Kohana_Exception('Configure PayU payments before this action!');
		}
	}
	
	public function get_url($type)
	{
		$base_url = rtrim($this->config['base_url'], '/').'/UTF/';
		
		switch($type)
		{
			case 'new':
				return $base_url.'NewPayment';
				
			case 'get':
				return $base_url.'Payment/get/xml';
		}
		
		throw new InvalidArgumentException('Cannot get PayU URL! Wrong type.');
	}
	
	public function set_field($name, $value)
	{
		$this->fields[$name] = $value;
		return $this;
	}
	
	public function get_field($name, $default = NULL)
	{
		return Arr::get($this->fields, $name, $default);
	}

	public function validate($values)
	{
		if ( !isset($values['pos_id']) 
			OR ! isset($values['session_id']) 
			OR ! isset($values['ts']) 
			OR ! isset($values['sig'])
		)
		{
			Kohana::$log->add(Log::ERROR, 'PayU: no required params');
			return FALSE;
		}

		if ($values['pos_id'] != $this->config['pos_id'])
		{
			Kohana::$log->add(Log::ERROR, 'PayU: wrong pos_id (:invalid != :valid)', array(
				':invalid' => $values['pos_id'],
				':valid' => $this->config['pos_id']
			));
			return FALSE;
		}

		$sig = $this->get_response_signature($values);

		if ($values['sig'] != $sig)
		{
			Kohana::$log->add(Log::ERROR, 'PayU: wrong signature (:invalid != :valid)', array(
				':invalid' => $values['sig'],
				':valid' => $sig
			));
			return FALSE;
		}

		return TRUE;
	}

	protected function get_response_signature($values)
	{
		return md5($values['pos_id'].$values['session_id'].$values['ts'].$this->config['key2']);
	}

	public function get_transaction_state($values)
	{
		$data = array(
			'pos_id'        => $this->config['pos_id'],
			'session_id'    => $values['session_id'],
			'ts'            => time(),
		);

		$data['sig'] = $this->get_payment_get_sig($data, $this->config['key']);

		$request = Request::factory($this->get_url('get'))
			->method('POST')
			->post($data);

		$response = $request->execute()->body();

		$xml = new SimpleXMLElement($response);

		$this->response = XML::as_array($xml->trans);

		$pending = array(1,4,5);
		$success = array(99);
		$fail = array(2,3,7,888);

		if ($xml->trans->amount)
		{
			$this->set_field('amount', $xml->trans->amount);
		}

		if (in_array( (int) $xml->trans->status, $pending))
			return self::STATUS_PENDING;
		
		if (in_array( (int) $xml->trans->status, $success))
			return self::STATUS_SUCCESS;
		
		if (in_array( (int) $xml->trans->status, $fail))
			return self::STATUS_FAILED;

		return FALSE;
	}

	protected function get_payment_get_sig(array $data, $key)
	{
		$sig = implode('', $data).$key;
		$sig = md5($sig);
		return $sig;
	}
	
	public function get_transaction_id()
	{
		return Arr::get($this->response, 'id');
	}
	
	public function get_fields()
	{
		$fields = array(
			'pos_id' => $this->config['pos_id'],
			'pos_auth_key' => $this->config['pos_auth_key'],
			'pay_type' => $this->get_field('pay_type'),
			'session_id' => $this->get_field('session_id'),
			'amount' => $this->get_field('amount'),
			'desc' => $this->get_field('desc'),
			'order_id' => $this->get_field('order_id'),
			'desc2' => $this->get_field('desc2'),
			'trsDesc' => $this->get_field('trsDesc'),
			'first_name' => $this->get_field('first_name'),
			'last_name' => $this->get_field('last_name'),
			'street' => $this->get_field('street'),
			'street_hn' => $this->get_field('street_hn'),
			'street_an' => $this->get_field('street_an'),
			'city' => $this->get_field('city'),
			'post_code' => $this->get_field('post_code'),
			'country' => $this->get_field('country'),
			'email' => $this->get_field('email'),
			'phone' => $this->get_field('phone'),
			'language' => $this->get_field('language'),
			'client_ip' => $this->get_field('client_ip'),
			'js' => $this->get_field('js', '0'),
			'sig' => NULL,
			'ts' => time(),
		);
		
		$fields['sig'] = $this->get_new_payment_sig($fields);
		
		return $fields;
	}
	
	protected function get_new_payment_sig($fields)
	{
		$required_fields = array(
			'pos_id', 'pay_type', 'session_id', 'pos_auth_key', 'amount', 'desc',
			'desc2', 'trsDesc', 'order_id', 'first_name', 'last_name', 'street',
			'street_hn', 'street_an', 'city', 'post_code', 'country', 'email',
			'phone', 'language', 'client_ip', 'ts', 'key1',
		);
		
		$str = '';
		
		foreach($required_fields as $name)
		{
			$str .= !empty($fields[$name]) ? $fields[$name] : '';
		}
		
		$str .= $this->config['key'];
		
		return md5($str);
	}

	public function render_form()
	{
		try
		{
			$content = View::factory('payment/payu/form')
					->set('payu', $this)
					->render();

		}
		catch (Exception $e)
		{
			Kohana_Exception::handler($e);
		}

		return $content;
	}
	
	public static function error_message($error_code)
	{
		$error_messages = array(
			"100" => "Brak lub błedna wartosc parametru pos id",
			"101" => "Brak parametru session id",
			"102" => "Brak parametru ts",
			"103" => "Brak lub błędna wartość parametru sig",
			"104" => "Brak parametru desc",
			"105" => "Brak parametru client ip",
			"106" => "Brak parametru first name",
			"107" => "Brak parametru last name",
			"108" => "Brak parametru street",
			"109" => "Brak parametru city",
			"110" => "Brak parametru post code",
			"111" => "Brak parametru amount",
			"112" => "Błedny numer konta bankowego",
			"113" => "Brak parametru email",
			"114" => "Brak numeru telefonu",
			"200" => "Inny chwilowy błąd",
			"201" => "Inny chwilowy błąd bazy danych",
			"202" => "Pos o podanym identyfikatorze jest zablokowany",
			"203" => "Niedozwolona wartosc pay type dla danego pos id",
			"204" => "Podana metoda płatnosci (wartosc pay type) jest chwilowo zablokowana dla danego pos id, np. przerwa konserwacyjna bramki płatniczej",
			"205" => "Kwota transakcji mniejsza od wartosci minimalnej",
			"206" => "Kwota transakcji wieksza od wartosci maksymalnej",
			"207" => "Przekroczona wartość wszystkich transakcji dla jednego klienta w ostatnim przedziale czasowym",
			"208" => "Pos działa w wariancie ExpressPayment lecz nie nastapiła aktywacja tego wariantu współpracy (czekamy na zgode działu obsługi klienta)",
			"209" => "Błędny numer pos id lub pos auth key",
			"211" => "Nieprawidłowa waluta transakcji",
			"212" => "Próba utworzenia transakcji częściej niż raz na minutę - dla nieaktywnej firmy",
			"500" => "Transakcja nie istnieje",
			"501" => "Brak autoryzacji dla danej transakcji",
			"502" => "Transakcja rozpoczeta wczesniej",
			"503" => "Autoryzacja do transakcji była juz przeprowadzana",
			"504" => "Transakcja anulowana wczesniej",
			"505" => "Transakcja przekazana do odbioru wczesniej",
			"506" => "Transakcja juz odebrana",
			"507" => "Bład podczas zwrotu srodków do klienta",
			"508" => "Klient zrezygnował z płatności",
			"599" => "Błedny stan transakcji, np. nie mozna uznac transakcji kilka razy lub inny, prosimy o kontakt",
			"777" => "Utworzenie transakcji spowoduje przekroczenie limitu transakcji dla firmy w trakcie weryfikacji, weryfikacja odbędzie się w ciągu jednego dnia roboczego",
			"999" => "Inny bład krytyczny - prosimy o kontakt",
		);
		
		return Arr::get($error_messages, $error_code, 'Wystąpił nieznany błąd!');
	}

}
