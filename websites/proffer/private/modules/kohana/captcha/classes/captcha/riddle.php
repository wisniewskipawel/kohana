<?php defined('SYSPATH') OR die('No direct access.');

class Captcha_Riddle extends Captcha
{
	/**
	 * @var string Captcha riddle
	 */
	private $riddle;

	/**
	 * Generates a new Captcha challenge.
	 *
	 * @return string The challenge answer
	 */
	public function generate_challenge()
	{
		// Load riddles from the current language
		$riddles = Kohana::$config->load('global.site.security.riddles');
		
		if(empty($riddles))
			throw new Kohana_Exception('Captcha riddles is not configured!');

		// Pick a random riddle
		$riddle = $riddles[array_rand($riddles)];

		// Store the question for output
		$this->riddle = $riddle['question'];

		// Return the answer
		return (string) $riddle['answers'];
	}

	/**
	 * Outputs the Captcha riddle.
	 *
	 * @param boolean $html HTML output
	 * @return mixed
	 */
	public function render($html = TRUE)
	{
		$this->update_response_session();
		
		return $this->riddle;
	}
	
	public function update_response_session()
	{
		Session::instance()->set('captcha_response', $this->response);
	}
	
	public function check($response, $valid_answers)
	{
		$valid_answers = explode("\n", $valid_answers);
		
		if(is_array($valid_answers) AND count($valid_answers))
		{
			foreach($valid_answers as $answer)
			{
				$answer = trim($answer);
				
				if(!empty($answer) AND $answer == $response)
					return TRUE;
			}
		}
		
		return FALSE;
	}

} // End Captcha Riddle Driver Class