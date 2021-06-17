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

    private $user;
    private $photoPost;
    private $photoComment;

    public function __construct(PhotoPost $photoPost, User $user, PhotoComment $photoComment)
    {
        $this->photoPost = $photoPost;
        $this->user = $user;
        $this->photoComment = $photoComment;
    }

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
     * @param \App\Http\Requests\PhotoFormRequest $request
     */
    public function processPhotoForm(PhotoFormRequest $request)
    {
        $userId = $request->user()->id;
        $userEmail = $request->user()->email;
        $userDirName = preg_replace("(@|\.)", "_", $userEmail);
        $fileName = $request->file('image')->getClientOriginalName();
        $dirPath = 'public/images/' . $userDirName;
        $storedImage = $request->image->storeAs($dirPath, $fileName);
        $this->photoPost->create([
            'user_id' => $userId,
            'image' => $storedImage,
            'description' => $request->description
        ]);
        return redirect(route('user.showPhotoForm'))
            ->with(['upload_success' => __("Upload was successful")]);
    }

    /**
     * @param string $photoOwnerId
     * @return \Illuminate\View\View
     */
    public function showPhotoList(string $photoOwnerId)
    {
        $user = $this->user->getUserById($photoOwnerId);
        if (!$user) {
            return redirect(route('newUsers'));
        }
        $userPhotoPosts = $user->photoPosts;
        return view('photo.photo_list', [
            'photoOwnerId' => $user->id,
            'username' => $user->name,
            'photoPosts' => $userPhotoPosts
        ]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function showUserList(): View
    {
        $users = $this->user->orderByDesc('created_at')->limit(12)->get();

        return view('photo.user_link_list', [
            'users' => $users
        ]);
    }

    /**
     * @param string $photoOwnerId
     * @param string $photoId
     * @return \Illuminate\View\View
     */
    public function showPhotoDetail(string $photoOwnerId, string $photoId)
    {
        $user = $this->user->getUserById($photoOwnerId);
        if (!$user) {
            return redirect(route('newUsers'));
        }
        $post = $user->photoPosts->where('id', $photoId)->first();
        if (!$post) {
            return redirect(
                route(
                    'showPhotoList',
                    ['photoOwnerId' => $photoOwnerId]
                )
            );
        }
        return view('photo.photo_detail', [
            'postOwnerPortrait' => $user->profile->image,
            'photoOwnerId' => $user->id,
            'postOwnerName' => $user->name,
            'post' => $post,
            'comments' => $post->comments
        ]);
    }

    /**
     * @param string $photoOwnerId
     * @param string $photoId
     * @return \Illuminate\View\View
     */
    public function showPhotoCommentForm(string $photoOwnerId, string $photoId): View
    {
        $user = $this->user->getUserById($photoOwnerId);
        $post = $user->photoPosts->where('id', $photoId)->first();
        return view('photo.photo_comment_form', [
            'photoOwnerId' => $user->id,
            'post' => $post
        ]);
    }

    /**
     * @param \App\Http\Requests\PhotoCommentFormRequest $request
     * @param string $photoOwnerId
     * @param string $photoId
     */
    public function processPhotoCommentForm(PhotoCommentFormRequest $request, string $photoOwnerId, string $photoId)
    {
        $commenterId = $request->user()->id;

        $this->photoComment->create([
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
