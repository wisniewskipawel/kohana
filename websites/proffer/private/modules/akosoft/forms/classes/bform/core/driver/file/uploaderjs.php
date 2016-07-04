<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2015, AkoSoft
 */

class Bform_Core_Driver_File_UploaderJS extends Bform_Driver_File_Uploader {

	public function execute_filters()
	{
		parent::execute_filters();

		if(Request::current()->query('fileuploader'))
		{
			$uploadedFiles = $this->_uploaded_files;

			$response = Response::factory();
			$response->send_headers();

			$json = array('files' => array());

			if($uploadedFiles)
			{
				foreach($uploadedFiles as $uploadedFile)
				{
					$fileInfo = $uploadedFile->asFileInfoArray();
					$fileInfo['serialized'] = $this->file_info_encode($fileInfo);
					$json['files'][] = $fileInfo;
				}
			}

			echo json_encode($json);
			exit;
		}
	}

}
