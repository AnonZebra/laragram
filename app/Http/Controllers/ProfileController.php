<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\ProfileFormRequest;

/**
 * Suppress overly aggressive PHPMD warning about using else.
 * (https://stackoverflow.com/questions/44100497/else-is-never-
 * necessary-and-you-can-simplify-the-code-to-work-without-else)
 *
 * @SuppressWarnings(PHPMD.ElseExpression)
 */
class ProfileController extends Controller
{
    /**
     * @return View
     */
    public function showProfile(): View
    {
        return view('profile');
    }

    /**
     * @param \App\Http\Requests\ProfileFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function processUpdateProfile(ProfileFormRequest $request)
    {
        if ($request['image']) {
            $userEmail = $request->user()->email;
            $userDirName = preg_replace("(@|\.)", "_", $userEmail);
            $fileName = $request->file('image')->getClientOriginalName();
            $dirPath = 'public/images/' . $userDirName;
            $storedImage = $request->image->storeAs($dirPath, $fileName);
            $request->user()->profile->updateImageAndDescription(
                $storedImage,
                $request->description
            );
        } else {
            $request->user()->profile->updateDescription($request->description);
        }

        return redirect(route('user.profile'));
    }
}
