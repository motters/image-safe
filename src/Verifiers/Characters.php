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
		if(!empty( $this->rules['imageCharacters']['unbanCharacters']))
			$this->disallowed = array_diff($this->disallowed, $this->rules['imageCharacters']['unbanCharacters']);
		//Addtional banned characters
		if(!empty( $this->rules['imageCharacters']['addbanCharacters']))
			$this->disallowed = array_merge($this->disallowed, $this->rules['imageCharacters']['addbanCharacters']);

		//Addtional  removal characters
		if(!empty( $this->rules['imageCharacters']['addremoveCharacters']))
			$this->remove = array_merge($this->remove, $this->rules['imageCharacters']['addremoveCharacters']);
		//Remove removal characters
		if(!empty( $this->rules['imageCharacters']['unremoveCharacters']))
			$this->remove = array_diff($this->remove, $this->rules['imageCharacters']['unremoveCharacters']);
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