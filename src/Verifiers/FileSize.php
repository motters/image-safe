<?php namespace Motters\ImageSafe\Verifiers;


class FileSize{
	
	/**
	 * Stores the file under validation
	 */
	protected $file;

	/**
	 * Stores the rules of validation
	 */
	protected $rules; 	

	/**
	 * image minimum file size
	 */
	protected $minSize;

	/**
	 * image maximum file size
	 */
	protected $maxSize;

	/**
	 * Kick start the verifier
	 */
	public function __construct( $file, $rules )
	{
		//set file and options
		$this->file = $file["tmp_name"];
		$this->rules = $rules;
		//Add some default rules if none present
		$this->setDefaultRules();
		//Set file size limits
		$this->setImageRequiredSize();
	}

	/** 
	 * Set some defaults incase the user does not set any rules
	 */
	protected function setDefaultRules()
	{
		if(empty($this->rules['imageFileSize']['maximum']))
			$this->rules['imageFileSize']['maximum'] = '2097152';

		if(empty($this->rules['imageFileSize']['minimum']))
			$this->rules['imageFileSize']['minimum'] = '10240';
	}

	/** 
	 * Set the image file sizes
	 */
	protected function setImageRequiredSize()
	{
		//Set image maximum file size
		if(!empty($this->rules['imageFileSize']['maximum']))
		{	
			$this->maxSize = (int) $this->rules['imageFileSize']['maximum'];
		}
		//Set image minimum file size
		if(!empty($this->rules['imageFileSize']['minimum']))
		{	
			$this->minSize = (int) $this->rules['imageFileSize']['minimum'];
		}
	}

	/**
	 * Get the images file size
	 */
	public function getImageFileSize()
	{
		return filesize($this->file);
	}

	/**
	 * Check image size vs the requested sizes
	 */
	public function checkImageDimensions()
	{
		//Get image diamentions
		$imageFileSize = $this->getImageFileSize();

		//Check file size compared to rules
		if($imageFileSize >= $this->minSize and $imageFileSize <= $this->maxSize){
			return true;
		}
		return false;
	}

	public function valid()
	{
		return $this->checkImageDimensions();;
	}

}