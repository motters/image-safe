## Image Safe ##

This is used when you want to verify the image being upload is an actual image

### Use ###

	public function uploadImageSafe()
	{
		//Start image safe validation
		$v = new Motters\ImageSafe\verify();

		//Set the rules for image safe
		$validationRules = [
			//Types of mimes that are allowed 
			'imageMimes', // Optional settings ['allowed'=>['image/jpeg; charset=binary', 'image/jpg; charset=binary']]

			//Make sure file name is aplha numerical (Files should always be renamed anway!)
			'imageFileName', // Optional settings ['allowed'=>['-','_'], 'maximumCharacters'=>'100', 'minimumCharacters'=>'1']

			//Minimum and maxium size of file image (Minimum file size will help stop denial of service attacks )
			'imageFileSize', // Optional settings ['maximum'=>'2097152', 'minimum'=>'10240']

			//Make sure the image has some valid and set dumensions
			'imageDimensionSize', // Optional settings ['height'=>'1024', 'width'=>'768']

			//Searches for elements in the images mimes that could potential be arbatry code, this is very beta!
			'imageCharacters', 
			/* ['unbanCharacters'=>['<?'], 'addbanCharacters'=>['<?'], 'addremoveCharacters'=>['<?'], 'unremoveCharacters'=>['<?']] */

			//Makes sure that the WHOLE image extention meets the below allowed white list 
			'imageFileExtension', // Optional settings ['allowed'=>['jpeg','jpeg.php']]
		];

		//Has validation passed or failed
		if( $v->validate( $_FILES["image"], $validationRules ) )
		{
			//Passed upload image (Laravel Only Example)
	        $file = Input::file('image');
	        $fileName = $file->getClientOriginalName();
	        $fileDest = 'img';
	        $upload = Input::file('image')->move($fileDest, $fileName);
		
	        return Redirect::to('');
		}

		//Failed show some error message
		dd('validation failed');
	}


### ToDo ###

Tidy code and write tests