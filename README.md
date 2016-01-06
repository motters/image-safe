## Image Safe ##

This is used when you want to verify file uploads that are restricted to images only!

Basic verification provided by main stream frameworks is not sufficient and is insecure. Which is the reason for myself
providing this package to the community.


### Use ###

	public function uploadImageSafe()
	{
		//Start image safe validation
		$v = new Motters\ImageSafe\ImageSafe();

		//Set the rules for image safe
		$validationRules = [
			//Types of mimes that are allowed 
			'Mimes', // Optional settings ['allowed'=>['image/jpeg; charset=binary', 'image/jpg; charset=binary']]

			//Make sure file name is aplha numerical (Files should always be renamed anway!)
			'FileName', // Optional settings ['allowed'=>['-','_'], 'maximumCharacters'=>'100', 'minimumCharacters'=>'1']

			//Minimum and maxium size of file image (Minimum file size will help stop denial of service attacks )
			'FileSize', // Optional settings ['maximum'=>'2097152', 'minimum'=>'10240']

			//Make sure the image has some valid and set dumensions
			'DimensionSize', // Optional settings ['height'=>'1024', 'width'=>'768']

			//Searches for elements in the images mimes that could potential be arbatry code, this is very beta!
			'Characters', // ['unbanCharacters'=>['<?'], 'addbanCharacters'=>['<?'], 'addremoveCharacters'=>['<?'], 'unremoveCharacters'=>['<?']]

			//Makes sure that the WHOLE image extention meets the below allowed white list 
			'FileExtension', // Optional settings ['allowed'=>['jpeg','jpeg.php']]
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

## Status ##
Active development and first stable release to be expected by 20/1/2016

## Security ##
If you find a way to bypass this package's protection please open an issue on Github or email me at sammottley@gmail.com.

## ToDo ##
Tidy code, write tests, provide demonstration of why this library is necessary.

## Special Thanks To ##
Nobody at the moment.