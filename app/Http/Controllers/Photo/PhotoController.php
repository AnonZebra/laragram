<?php

namespace App\Http\Controllers\Photo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Http\Requests\PhotoCommentFormRequest;
use App\Http\Requests\PhotoFormRequest;
use App\Models\PhotoPost;
use App\Models\PhotoComment;

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
            ->with(['upload_success' => __("Upload was successful")]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $photoOwnerId
     * @return \Illuminate\View\View
     */
    public function showPhotoList(Request $request, $photoOwnerId): View
    {
        $user = User::getUserById($photoOwnerId);
        $userPhotoPosts = $user->photoPosts;
        return view('photo.photo_list', [
            'photoOwnerId' => $user->id,
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
            'photoOwnerId' => $user->id,
            'postOwnerName' => $user->name,
            'post' => $post,
            'comments' => $post->comments
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $photoOwnerId
     * @param $photoId
     * @return \Illuminate\View\View
     */
    public function showPhotoCommentForm(Request $request, $photoOwnerId, $photoId): View
    {
        $user = User::getUserById($photoOwnerId);
        $post = $user->photoPosts->where('id', $photoId)->first();
        return view('photo.photo_comment_form', [
            'photoOwnerId' => $user->id,
            'post' => $post
        ]);
    }

    /**
     * @param App\Http\Requests\PhotoCommentFormRequest $request
     * @param $photoOwnerId
     * @param $photoId
     */
    public function processPhotoCommentForm(PhotoCommentFormRequest $request, $photoOwnerId, $photoId)
    {
        $commenterId = $request->user()->id;

        PhotoComment::create([
            'user_id' => $commenterId,
            'photo_post_id' => $photoId,
            'body' => $request->comment
        ]);

        return redirect(
            route(
                'showPhotoDetail', 
                ['photoOwnerId' => $photoOwnerId, 'photoId' => $photoId]
            )
        );
    }
}
