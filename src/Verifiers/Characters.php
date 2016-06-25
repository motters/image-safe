<?php namespace Motters\ImageSafe\Verifiers;


class Characters{

	/**
	 * Stores the file under validation
	 */
	protected $file;

	/**
	 * Stores the rules of validation
	 */
	protected $rules;

	/**
	 * Stores the rules of validation
	 */
	protected $disallowed = array( '<? ', '<?php', '<script>', 'javascript:', 'vbscript:', 'livescript:', 'onmouseover', 'onerror', '.php');

	/** 
	 * When looking for disallowed remove the below
	 */
	protected $remove = array('<!--', '-->', '\0', '&#x0A;');

	/**
	 * Kick start the verifier
	 */
	public function __construct( $file, $rules )
	{
		//set file and options
		$this->file = $file["tmp_name"];
		$this->rules = $rules;
		//Set disallowed and removal
		$this->settings();
	}

	/**
	 * Alter the disallowed and remove dependant on the users set rules
	 */
	protected function settings()
	{
		//Un ban characters
		if(!empty( $this->rules['Characters']['unbanCharacters']))
			$this->disallowed = array_diff($this->disallowed, $this->rules['Characters']['unbanCharacters']);
		//Addtional banned characters
		if(!empty( $this->rules['Characters']['addbanCharacters']))
			$this->disallowed = array_merge($this->disallowed, $this->rules['Characters']['addbanCharacters']);

		//Addtional  removal characters
		if(!empty( $this->rules['Characters']['Characters']))
			$this->remove = array_merge($this->remove, $this->rules['Characters']['addremoveCharacters']);
		//Remove removal characters
		if(!empty( $this->rules['Characters']['Characters']))
			$this->remove = array_diff($this->remove, $this->rules['Characters']['unremoveCharacters']);
	}

	/**
	 * Check if file contains any of the banned characters/words
	 */
	protected function contains($string, array $array)
	{
	    foreach($array as $value) {
	        if (stripos($string,$value) !== false)
	        {
	        	return true;
	        } 
	    }
	    return false;
	}

	public function valid()
	{	
		//Check if file contains any banned strings
		if ($this->contains(str_replace($this->remove, '', file_get_contents($this->file)), $this->disallowed ))
		{
			return false;
		}
		return true;	
	}

}