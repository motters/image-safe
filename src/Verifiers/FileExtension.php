<?php namespace Motters\ImageSafe\Verifiers;


class FileExtension{
	
	/**
	 * Stores the file extention of file under validation
	 */
	protected $fileExtension;

	/**
	 * Stores the rules of validation
	 */
	protected $rules; 

	/**
	 * Kick start the verifier
	 */
	public function __construct( $fileExtension, $rules )
	{
		//set file and options
		$this->fileExtension = $this->getImageFullExtension($fileExtension['name']);
		$this->rules = $rules;
		//Add some default rules if none present
		$this->setDefaultRules();
	}

	/** 
	 * Set some defaults incase the user does not set any rules
	 */
	protected function setDefaultRules()
	{
		if(empty($this->rules['imageFileExtension']['allowed']))
			$this->rules['imageFileExtension']['allowed'] = ['jpeg', 'jpg', 'png', 'gif'];
	}

	/**
	 * Get the full extension of the image
	 */
	public function getImageFullExtension( $file )
	{
		$fileExt = explode('.',$file);
		return $fileExt[count($fileExt)-1];
		//return substr(str_replace($fileExt[0], '', $file), 1);
	}

	public function valid()
	{
		if(in_array($this->fileExtension, $this->rules['imageFileExtension']['allowed'])){
			return true;
		}
		return false;
	}

}