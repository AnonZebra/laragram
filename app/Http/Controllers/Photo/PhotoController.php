<?php

namespace App\Http\Controllers\Photo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Http\Requests\PhotoFormRequest;
use App\Models\PhotoPost;

use App\Models\User;

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
        return redirect(route('user.showPhotoForm'))
            ->with(['upload_success' => __("Upload was successful")]);;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\View\View
     */
    public function showPhotoList(Request $request, $id): View
    {
        $user = User::getUserById($id);
        $userPhotoPosts = $user->photoPosts;
        return view('photo.photo_list', [
            'userId' => $user->id,
            'username' => $user->name,
            'photoPosts' => $userPhotoPosts
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function showUserList(Request $request): View
    {
        $users = User::orderByDesc('created_at')->limit(12)->get();

        return view('photo.user_link_list', [
            'users' => $users
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $userId
     * @param $photoId
     * @return \Illuminate\View\View
     */
    public function showPhotoDetail(Request $request, $userId, $photoId): View
    {
        $user = User::getUserById($userId);
        $post = $user->photoPosts->where('id', $photoId)->first();
        return view('photo.photo_detail', [
            'postOwnerPortrait' => $user->profile->image,
            'postOwnerId' => $user->id,
            'postOwnerName' => $user->name,
            'post' => $post
        ]);
    }
}
