<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Outputs the dynamic Captcha resource.
 * Usage: Call the Captcha controller from a view, e.g.
 *        <img src="<?php echo URL::site('captcha') ?>" />
 *
 * $Id: captcha.php 3769 2008-12-15 00:48:56Z zombor $
 *
 * @package		Captcha
 * @subpackage	Controller_Captcha
 * @author		Michael Lavers
 * @author		Kohana Team
 * @copyright	(c) 2008-2010 Kohana Team
 * @license		http://kohanaphp.com/license.html
 */
class Controller_Captcha extends Controller {

	/**
	 * @var boolean Auto render template
	 **/
	public $auto_render = FALSE;

	/**
	 * Output the captcha challenge
	 *
	 * @param string $group Config group name
	 */
	public function action_index()
	{
		$group = $this->request->param('group');
		
		// Output the Captcha challenge resource (no html)
		// Pull the config group name from the URL
		Captcha::instance($group ?: 'default')
			->set_request_response($this->response)
			->render(FALSE);
	}
	
	public function after()
	{
		Captcha::instance()->update_response_session();
	}

} // End Captcha_Controller
