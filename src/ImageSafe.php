<?php namespace Motters\ImageSafe;

class ImageSafe {

	/**
	 * Stores the possible verification methods
	 */
	protected $possibleVerification = ["DimensionSize", "Mimes", "Characters", "FileExtension", "FileSize", "FileName"];

	/**
	 * Stores the wanted verification methods
	 */
	protected $wantedVerification;

	/**
	 * Stores the file under validation
	 */
	protected $file;

	/**
	 * Stores the allowed image types
	 */
	protected $rules;

	/**
	 * Verify image via all set verifiers
	 * @param $fileLocation the location of the file
	 * @pram $rules the rules to verify the image to
	 * @param bool $missVerification
	 * @return bool
	 */
	public function validate( $fileLocation, $rules, $missVerification = false )
	{
		//Set vars
		$this->file = $fileLocation;
		$this->rules = $rules;

		//Find what verification methods are not wanted
		if($missVerification)
		{ 
			$wanted = new Helpers\verificationWanted( $this->possibleVerification, $missVerification );
			$this->wantedVerification = $wanted->getWantedVerification();
		}else{
			$this->wantedVerification = $this->possibleVerification;
		}

		//Verify for each wanted library
		foreach($this->wantedVerification as $key => $verifier)
		{
			if(!$this->verifyForVerificationMethod($verifier))
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * Support multiple file upload
	 * @param int $file
	 * @return array
	 */
	public function selectFile($file)
	{
		return [
			'name' => $this->file['name'][$file],
			'type' => $this->file['type'][$file],
			'tmp_name' => $this->file['tmp_name'][$file],
			'error' => $this->file['error'][$file],
			'size' => $this->file['size'][$file]
		];
	}

	/**
	 * Run though verifications
	 */
	public function runVerifications($verifier, $file)
	{
		if(!empty($this->rules[str_replace('check', 'image', $verifier)]) or in_array(str_replace('check', 'image', $verifier), $this->rules) ){
			$class = "Motters\\ImageSafe\\Verifiers\\".$verifier;
			$verify = new $class($file, $this->rules);
			return $verify->valid();
		}
		return true;
	}

	/**
	 * Runs the associated verifier for the verification method
	 * @pram $library name of the library
	 * @return bool
	 */
	public function verifyForVerificationMethod( $verifier )
	{
		if(is_array($this->file['name'])){
			foreach($this->file['name'] as $no => $name){
				$result = $this->runVerifications($verifier, $this->selectFile($no));
				if(!$result)
					return $result;
			}
		}
		return true;
	}

}