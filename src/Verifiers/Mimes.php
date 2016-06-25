<?php namespace Motters\ImageSafe\Verifiers;


use Motters\ImageSafe\Helpers\LibrariesAvailable;

class Mimes{

	/**
	 * Stores the file under validation
	 */
	protected $file;

	/**
	 * Stores the allowed image types
	 */
	protected $rules; 

	/**
	 * Kick start the verifier
	 */
	public function __construct( $file, $rules )
	{
		//Check library avalible for class
		$this->checkLibraryAvailable();

		//Set vars
		$this->file = $file["tmp_name"];
		$this->rules = $rules;

		//Add some default rules if none present
		$this->setDefaultRules();
	}

	/**
	 * Check whether the php libraries are avalible for this verification method
	 */
	protected function checkLibraryAvailable()
	{
		$check = new LibrariesAvailable('Fileinfo');
	}

	/** 
	 * Set some defaults incase the user does not set any rules
	 */
	protected function setDefaultRules()
	{
		if(empty($this->rules['Mimes']['allowed']))
		{
			$this->rules['Mimes']['allowed'] = [
				'image/jpeg; charset=binary', 
				'image/jpg; charset=binary',
				'image/png; charset=binary',
				'image/gif; charset=binary',
			];
		}
	}

	/** 
	 * Validate the image aganst its mimes
	 */
	public function valid()
	{
		//Find file mimes type
		$findMime = new \finfo();
		$mime = $findMime->file($this->file, FILEINFO_MIME);

		//Compare file mimes tpye with allowed types
		if(in_array($mime, $this->rules['Mimes']['allowed']))
		{
			return true;
		}

		return false;
	}


}