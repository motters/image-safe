<?php namespace Motters\ImageSafe\Verifiers;


use Motters\ImageSafe\Helpers\LibrariesAvailable;

class DimensionSize{
	
	/**
	 * Stores the file under validation
	 */
	protected $file;

	/**
	 * Stores the rules of validation
	 */
	protected $rules; 	

	/**
	 * required image height
	 */
	protected $imageHeight = null;

	/**
	 * required image width
	 */
	protected $imageWidth = null;

	/**
	 * Kick start the verifier
	 */
	public function __construct( $file, $rules )
	{
		//Check if required php librarys are avalble
		$this->checkLibraryAvailable();
		//set file and options
		$this->file = $file["tmp_name"];
		$this->rules = $rules;
		//Set file size limits
		$this->setImageRequiredSize();

	}

	/**
	 * Check whether the php libraries are avalible for this verification method
	 */
	protected function checkLibraryAvailable()
	{
		$check = new LibrariesAvailable('gd');
	}

	/** 
	 * Set the image required sizes
	 */
	protected function setImageRequiredSize()
	{
		//Set image maximum size
		if(!empty($this->rules['DimensionSize']['height']))
		{	
			$this->imageHeight = (int) $this->rules['DimensionSize']['height'];
		}
		//Set image minimum size
		if(!empty($this->rules['DimensionSize']['width']))
		{	
			$this->imageWidth = (int) $this->rules['DimensionSize']['width'];
		}
	}

	/**
	 * Get the images diamentions
	 */
	public function getImageDimensions()
	{
		return getimagesize($this->file);
	}

	/**
	 * Check image size vs the requested sizes
	 */
	public function checkImageDimensions()
	{
		//Get image diamentions
		$imageDimensions = $this->getImageDimensions();

		if($imageDimensions[0] == $this->imageHeight and $imageDimensions[1] == $this->imageWidth)
		{
			//Image size restricted 
			return true;
		}
		elseif( (($this->imageHeight == null) and $imageDimensions[0] > 0) and (($this->imageWidth == null) and $imageDimensions[1] > 0) )
		{
			//Any size image but the image must have diamentions
			return true;
		}
		elseif( (($this->imageHeight != null) and $imageDimensions[0] == $this->imageHeight) and  $imageDimensions[1] > 0)
		{
			//Validate just image height width just needs to have any dimentions
			return true;
		}
		elseif( (($this->imageWidth != null) and $imageDimensions[1] == $this->imageWidth) and  $imageDimensions[0] > 0)
		{
			//Validate just image width, height just needs to have any dimentions
			return true;
		}

		return false;
	}

	public function valid()
	{
		return $this->checkImageDimensions();
	}

}