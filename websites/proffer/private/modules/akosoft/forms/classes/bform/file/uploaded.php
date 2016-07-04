<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Bform_File_Uploaded extends Bform_File_Detached {

	/**
	 * @param array $uploadedFiles $_FILES array
	 * @return static[]
	 */
	public static function parseUploadedFiles(array $uploadedFiles)
	{
		$parsed = array();
		
        foreach ($uploadedFiles as $field => $uploadedFile)
		{
            if (!isset($uploadedFile['error']))
			{
                if (is_array($uploadedFile))
				{
                    $parsed[$field] = static::parseUploadedFiles($uploadedFile);
                }
                continue;
            }
			
            $parsed[$field] = array();
			
            if (!is_array($uploadedFile['error']))
			{
				if(!empty($uploadedFile['tmp_name']))
				{
					$parsed[$field] = new static(
						$uploadedFile['tmp_name'],
						isset($uploadedFile['tmp_name']) ? $uploadedFile['name'] : null,
						isset($uploadedFile['type']) ? $uploadedFile['type'] : null,
						isset($uploadedFile['size']) ? $uploadedFile['size'] : null,
						$uploadedFile['error']
					);
				}
            }
			else
			{
                foreach ($uploadedFile['error'] as $fileIdx => $error)
				{
					if(!empty($uploadedFile['tmp_name'][$fileIdx]))
					{
						$parsed[$field][] = new static(
							$uploadedFile['tmp_name'][$fileIdx],
							isset($uploadedFile['tmp_name']) ? $uploadedFile['name'][$fileIdx] : null,
							isset($uploadedFile['type']) ? $uploadedFile['type'][$fileIdx] : null,
							isset($uploadedFile['size']) ? $uploadedFile['size'][$fileIdx] : null,
							$uploadedFile['error'][$fileIdx]
						);
					}
                }
            }
        }
		
        return $parsed;
	}
	
	public function __construct($file, $name = NULL, $type = null, $size = null, $error = UPLOAD_ERR_OK)
	{
		parent::__construct($file, $name);
		
        $this->type = $type;
        $this->size = $size;
        $this->error = $error;
	}
	
	public function getType()
	{
		return 'uploaded';
	}
	
	public function getSize()
	{
		return $this->size;
	}
	
	public function isValid()
	{
		return $this->error === UPLOAD_ERR_OK
			AND is_uploaded_file($this->file);
	}
	
	public function moveTo($targetPath)
    {
        if(!is_writable(dirname($targetPath))) 
		{
            throw new InvalidArgumentException('Upload target path is not writable');
        }
		
		if(!is_uploaded_file($this->file))
		{
			throw new RuntimeException(sprintf('%1s is not a valid uploaded file', $this->file));
		}
		
		if(!move_uploaded_file($this->file, $targetPath))
		{
			throw new RuntimeException(sprintf('Error moving uploaded file %1s to %2s', $this->name, $targetPath));
		}
        
		return new Bform_File_Detached($targetPath, $this->getClientFilename());
    }
	
}