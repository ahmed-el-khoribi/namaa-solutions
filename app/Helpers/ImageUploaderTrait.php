<?php
namespace App\Helpers;

use Image;

trait ImageUploaderTrait
{
	public function createFileName($file)
	{
        $originalName = $file->getClientOriginalName();

		$fileName = time() .'_'. $originalName;

        return $fileName;
    }

	public function saveFile($file, $fileName)
	{
		$file->move('uploads/files/', $fileName);
    }

    /**
     * Save different sizes for images
     */
    public function originalImage($file, $current_name)
    {
        $accountOriginalDestination = 'uploads/images/original/';

        Image::make($file)->save($accountOriginalDestination . $current_name);
    }

    public function mediumImage($file, $current_name, $width=600, $height=300)
    {
        $accountMediumDestination = 'uploads/images/medium/';

        Image::make($file)
                ->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($accountMediumDestination . $current_name);
    }

    public function thumbImage($file, $current_name, $width=100, $height=100)
    {
        $accountThumbnailDestination = 'uploads/images/thumbnail/';

        Image::make($file)
                ->resize($width, $height)
                    ->save($accountThumbnailDestination . $current_name);
    }

    public function base64Image($file, $fileName)
    {
        $accountOriginalDestination = 'uploads/images/original/';

        Image::make(file_get_contents($file))
                ->save($accountOriginalDestination . $fileName);
    }

}
