<?php namespace Motters\ImageSafe\Helpers;

class VerificationWanted {

	/**
	 * Stores the wanted verification methods
	 */
	protected $verificationWanted;

	/**
	 *
	 * @param an $verification
	 * @param bool|an $missVerification
	 * @throws RequestedMissLibraryNotFound
	 * @internal param an $verification array of possable verification methods
	 * @internal param an $missVerification array of verification methods not wanted
	 */
	public function __construct( $verification, $missVerification = false )
	{

		//Find wanted libarues
		$this->verification( $verification, $missVerification );

	}

	/**
	 * Fetch the wanted verification methods
	 */
	public function getWantedVerification( )
	{

		return $this->verificationWanted;

	}

	/**
	 * Sets the wantedverification var
	 * @param $verifications
	 * @param $missVerifications
	 * @throws RequestedMissLibraryNotFound
	 * @internal param verifications $ an array of possable verification methods
	 * @internal param missVerification $ an array of verification methods not wanted
	 */
	protected function verification( $verifications, $missVerifications )
	{
		//If user wants to skip a library
		if( $missVerifications )
		{
			//For each library wanted to skip
			foreach( $missVerifications as $id => $verification )
			{
				//Find the key of the library to skip
				$key = array_search($verification, $verifications);

				//If key found unset the key and value
				if( $key !== false )
				{
					//unset
				    unset( $verifications[ $key ] );
				}
				else
				{
					//Throw Exception
					throw new RequestedMissLibraryNotFound('The library you required to be skipped was not found in the list of passable libraries.');
				}

			}

		}

		//Set the wanted libraries
		$this->verificationWanted = $verifications;
	}


}