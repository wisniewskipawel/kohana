<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Controller_CKEditor extends Controller_Ajax_Main {

	/**
	 * @return null
	 * @throws HTTP_Exception_403
	 */
	public function action_upload()
	{
		// Optional: instance name (might be used to load a specific configuration file or anything else).
		//$CKEditor = $this->request->query('CKEditor');

		// Optional: might be used to provide localized messages.
		//$langCode = $this->request->query('langCode');

		$token = $this->request->post('ckCsrfToken');

		if($token !== $_COOKIE['ckCsrfToken'])
		{
			throw new HTTP_Exception_403;
		}

		$directory = Upload::$default_directory.'/images/';

		if(!is_dir(DOCROOT.$directory))
		{
			if(!mkdir(DOCROOT.$directory, 0777, TRUE))
			{
				throw new RuntimeException(sprintf('Directory: "%s" cannot be created!', Debug::path(DOCROOT.$directory)));
			}
		}

		$files = Bform_File_Uploaded::parseUploadedFiles($_FILES);

		foreach($files as $file)
		{
			if($file->isValid() AND Bform_Driver_File_Uploader::validate_image($file))
			{
				$image_uri = $directory.time().'_'.$file->getSafeFilename();
				if($file_saved = $file->moveTo(DOCROOT.$image_uri))
				{
					return $this->response_upload_url($this->request, URL::site($image_uri));
				}
			}
			else
			{
				return $this->response_message($this->request, 'Not valid image file!');
			}
		}

		return $this->response_message($this->request, 'Error!');
	}

	/**
	 * @param Request $request
	 * @param $url
	 * @return null
	 */
	protected function response_upload_url(Request $request, $url)
	{
		return $this->handle_upload_response($request, $url, NULL);
	}

	/**
	 * @param Request $request
	 * @param $message
	 * @return null
	 */
	protected function response_message(Request $request, $message)
	{
		return $this->handle_upload_response($request, NULL, $message);
	}

	/**
	 * @param Request $request
	 * @param $upload_url
	 * @param $message
	 * @return null
	 */
	protected function handle_upload_response(Request $request, $upload_url, $message)
	{
		if($funcNum = $request->query('CKEditorFuncNum'))
		{
			$this->response->body(
				"<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$upload_url', '$message');</script>"
			);
			return NULL;
		}

		if($request->query('responseType') === 'json')
		{
			return $this->response_json(array(
				"uploaded" => !empty($upload_url),
			    "fileName" => basename($upload_url),
			    "url" => $upload_url,
			    "error" => array(
				    "message" => $message,
				)
			));
		}

		return NULL;
	}

}