<?php namespace Motters\ImageSafe\Helpers;

class LibrariesAvailable {

	/**
	 * 
	 * @var library the library to check exisits
	 */
	public function __construct( $library )
	{

		//Find wanted libarues
		$this->librariesAvailable( $library );

	}

	/**
	 * Detects if the php library is avalible
	 * @pram $library the library to check exisits
	 * @return bool
	 * @throws MissingLibrary
	 */
	protected function librariesAvailable( $library )
	{

		//If the extention is not loaded
		if( extension_loaded( $library ) )
		{

			return true;

		}

		throw new \Motters\ImageSafe\Exceptions\ExecutionException('The php based library '.$library.' can not be found on the server.');

	}

}