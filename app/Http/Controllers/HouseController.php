<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\House;
use App\Models\Image;

class HouseController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }
    public function show(House $house){
    	return $house;
    	// $house = House::findorfail($request->id);    
    }
	public function fetchImages(House $house)
	{
	 	return $house->images;
	 }

	public function json(House $house)
{
    $images = $house->images;
    $data = [];

    foreach ($images as $key => $image) {
        $data[] = [
            'imageSrc' => $image->image, 

        ];
    }
    return $data;
}

    public function createImages(Request $request)
    {
    	$this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png',
        ]);
        $picName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }

    public function store(Request $request){
    	// validate request
        $this->validate($request, [
            'caption' => 'required',
            'iconImage' => 'required',
            'id'=>'required',
        ]);
        if (House::findorfail($request->id)->images->count()>4) {
        	//delete the image
        	$fileName = $request->iconImage;
           $this->deleteFileFromServer($fileName, false);
         return "You can`t create more than 5 images for the same house";
        }
        return Image::create([
            'caption' => $request->caption,
            'image' => $request->iconImage,
            'house_id'=>$request->id
        ]);
    }   public function deleteFileFromServer($fileName, $hasFullPath = false)
       {
           if (!$hasFullPath) {
               $filePath = public_path() . '/uploads/' . $fileName;
           }
           if (file_exists($filePath)) {
               @unlink($filePath);
           }
           return;
       }
}
