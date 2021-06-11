<?php

namespace App\Http\Controllers\Photo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Http\Requests\PhotoFormRequest;
use App\Models\PhotoPost;

class PhotoController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function showPhotoForm(Request $request): View
    {
        $user = $request->user();
        return view('photo.photo_form', [
            'userName' => $user->name
        ]);
    }

    /**
     * @param App\Http\Requests\PhotoFormRequest $request
     */
    public function processPhotoForm(PhotoFormRequest $request)
    {
        $userId = $request->user()->id;
        $userEmail = $request->user()->email;
        $userDirName = preg_replace("(@|\.)", "_", $userEmail);
        $fileName = $request->file('image')->getClientOriginalName();
        $dirPath = 'public/images/' . $userDirName;
        $storedImage = $request->image->storeAs($dirPath, $fileName);
        PhotoPost::create([
            'user_id' => $userId,
            'image' => $storedImage,
            'description' => $request->description
        ]);
        return redirect(route('user.showPhotoForm'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function showPhotoList(Request $request): View
    {
        $user = $request->user();
        $userPhotoPosts = $user->photoPosts;
        return view('photo.photo_list', [
            'userName' => $user->name,
            'photoPosts' => $userPhotoPosts
        ]);
    }
}
