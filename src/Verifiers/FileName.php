<?php namespace Motters\ImageSafe\Verifiers;


class FileName{
	
	/**
	 * Stores the file name of file under validation
	 */
	protected $fileName;

	/**
	 * Stores the rules of validation
	 */
	protected $rules; 

	/**
	 * Kick start the verifier
	 */
	public function __construct( $fileName, $rules )
	{
		//set file and options
		$this->fileName = $this->getImageName($fileName['name']);
		$this->rules = $rules;
		//Set some default is the user does bot set any rules
		$this->setDefaultRules();
	}

	/** 
	 * Set some defaults incase the user does not set any rules
	 */
	protected function setDefaultRules()
	{
		if(empty($this->rules['imageFileName']['allowed']))
			$this->rules['imageFileName']['allowed'] = ['-','_',' '];

		if(empty($this->rules['imageFileName']['maximumCharacters']))
			$this->rules['imageFileName']['maximumCharacters'] = 100;

		if(empty($this->rules['imageFileName']['minimumCharacters']))
			$this->rules['imageFileName']['minimumCharacters'] = 1;
	}

	/**
	 * Get the name of the image
	 */
	private function getImageName( $file )
	{
		$fileName = explode('.',$file);
		return $fileName[0];
	}

	/**
	 * Is the file name alpha numerical minus the allowed asciis
	 */
	private function isAlphaNumerical( )
	{
		if(ctype_alnum(str_replace($this->rules['imageFileName']['allowed'], '', $this->fileName))) { 
		    return true;
		}
		return false;
	}

	/**
	 * Is the file name between the length limits 
	 */
	private function isBetweenLength( )
	{
		if(strlen($this->fileName) >= $this->rules['imageFileName']['minimumCharacters'] and  strlen($this->fileName) <= $this->rules['imageFileName']['maximumCharacters']) { 
		    return true;
		}
		return false;
	}

	public function valid()
	{
		if($this->isAlphaNumerical() and $this->isBetweenLength())
		{
			return true;
		}
		return false;
	}

}