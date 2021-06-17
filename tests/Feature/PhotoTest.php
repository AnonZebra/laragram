<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\PhotoPost;
use App\Models\PhotoComment;

class PhotoTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->userInfo = [
            'name' => '中島 学',
            'email' => 'akira.sasaki@foobar.net',
            'password' => 'secretpass',
        ];
        $this->randomUser = User::factory()->create();
    }

    /**
     * Logged-in user can view photo submission form.
     */
    public function testViewPhotoForm()
    {
        $this->actingAs($this->randomUser);
        $response = $this->get(route('user.showPhotoForm'));

        $response
            ->assertStatus(200);
    }

    /**
     * Logged-in user can submit photo form, upon which
     * a photo post record is created and the sent image
     * is saved.
     */
    public function testSendPhotoForm()
    {
        $userInfo = $this->userInfo;
        $user = User::create([
            'name' => $userInfo['name'],
            'email' => 'foo@example.com',
            'password' => bcrypt($userInfo['password']),
        ]);
        Storage::fake('profiles');
        $fName = 'temp.jpg';
        $file = UploadedFile::fake()->image($fName);
        $description = "Such a cool seamstress!";

        $this->actingAs($user);
        $response = $this->post(route('user.processPhotoForm'), [
            'image' => $file,
            'description' => $description
        ]);

        $dbDesc = PhotoPost::where('user_id', $user->id)->first()->description;

        //description updated
        $this->assertEquals($dbDesc, $description);
        // redirected
        $response->assertStatus(302);
        // image saved
        Storage::disk('public')
            ->assertExists(
                'images/foo_example_com/' . $file->name
            );
    }

    /**
     * Guest user can view user's list of photos.
     */
    public function testViewSingleUserPhotos()
    {
        $userInfo = $this->userInfo;
        $user = User::create([
            'name' => $userInfo['name'],
            'email' => 'foo@example.com',
            'password' => bcrypt($userInfo['password']),
        ]);
        Storage::fake('profiles');
        $fName = 'temp.jpg';
        $file = UploadedFile::fake()->image($fName);
        $description = "Such a cool seamstress!";
        $this->actingAs($user);
        $response = $this->post(route('user.processPhotoForm'), [
            'image' => $file,
            'description' => $description
        ]);
        Auth::logout();

        $response = $this->get(
            route(
                'showPhotoList',
                ['photoOwnerId' => $user->id]
            )
        );

        $response
            ->assertStatus(200);

        $this->assertEquals($response['photoPosts'][0]->description, $description);
    }

    /**
     * Guest user can view list of new users.
     */
    public function testViewNewUsersList()
    {
        $userInfo = $this->userInfo;
        $genUsers = User::factory()->count(2)->create();
        Storage::fake('profiles');
        $fName = 'temp.jpg';
        $file = UploadedFile::fake()->image($fName);
        $description = "Such a cool seamstress!";
        foreach ($genUsers->all() as $user) {
            $this->actingAs($user);
            $this->post(route('user.processPhotoForm'), [
                'image' => $file,
                'description' => $description
            ]);
        }
        Auth::logout();

        $response = $this->get(route('newUsers'));

        $allUsers = User::all();

        $response
            ->assertStatus(200);

        $this->assertEquals($response['users'][0]->name, $allUsers[0]->name);
    }

    /**
     * Guest user can get detail view of a user's single image.
     */
    public function testViewSinglePhoto()
    {
        $userInfo = $this->userInfo;
        $user = User::factory()->create();
        Storage::fake('profiles');
        $fName = 'temp.jpg';
        $file = UploadedFile::fake()->image($fName);
        $description = "Such a cool seamstress!";
        $this->actingAs($user);
        $this->post(route('user.processPhotoForm'), [
            'image' => $file,
            'description' => $description
        ]);
        Auth::logout();

        $pP = $user->photoPosts->first();

        $response = $this->get(
            route('showPhotoDetail', [
                'photoOwnerId' => $user->id,
                'photoId' => $pP->id
            ])
        );

        $response
            ->assertStatus(200)
            ->assertViewHas('postOwnerName', $user->name);
    }

    /**
     * Guest user trying to get detail view of an image for a user
     * where the image doesn't exist is redirected to the user's main page.
     */
    public function testViewSingleNonexistentPhoto()
    {
        $userInfo = $this->userInfo;
        $user = User::factory()->create();
        Storage::fake('profiles');
        $fName = 'temp.jpg';
        $file = UploadedFile::fake()->image($fName);
        $description = "Such a cool seamstress!";
        $this->actingAs($user);
        $this->post(route('user.processPhotoForm'), [
            'image' => $file,
            'description' => $description
        ]);
        Auth::logout();

        $pP = $user->photoPosts->first();

        $response = $this->get(
            route('showPhotoDetail', [
                'photoOwnerId' => $user->id,
                'photoId' => $pP->id + 1
            ])
        );

        $response
            ->assertStatus(302)
            ->assertRedirect(
                route('showPhotoList', [
                    'photoOwnerId' => $user->id
                ])
            );
    }

    /**
     * Guest user trying to get photo list view of an image for a user
     * that doesn't exist is redirected.
     */
    public function testViewSingleNonexistentUserPhotoList()
    {
        $response = $this->get(
            route('showPhotoList', [
                'photoOwnerId' => 9999
            ])
        );

        $response
            ->assertStatus(302)
            ->assertRedirect();
    }

    /**
     * Registered user can comment on another user's image.
     */
    public function testCommentOnPhoto()
    {
        $userInfo = $this->userInfo;
        $user = User::factory()->create();
        $commentUser = User::factory()->create();
        Storage::fake('profiles');
        $fName = 'temp.jpg';
        $file = UploadedFile::fake()->image($fName);
        $description = "Such a cool seamstress!";
        $this->actingAs($user);
        $this->post(route('user.processPhotoForm'), [
            'image' => $file,
            'description' => $description
        ]);
        Auth::logout();

        $pP = PhotoPost::all()->first();

        $this->actingAs($commentUser);

        $getResponse = $this->get(
            route('user.showPhotoCommentForm', [
                'photoOwnerId' => $user->id,
                'photoId' => $pP->id
            ])
        );

        $getResponse
            ->assertStatus(200);

        $postResponse = $this->post(
            route('user.showPhotoCommentForm', [
                'photoOwnerId' => $user->id,
                'photoId' => $pP->id
            ]),
            ['comment' => 'foobar']
        );

        $postResponse
            ->assertStatus(302)
            ->assertRedirect(
                route('showPhotoDetail', [
                    'photoOwnerId' => $user->id,
                    'photoId' => $pP->id
                ])
            );

        $comment = PhotoComment::all()->first();

        $this->assertEquals($comment->id, 1);
        $this->assertEquals($comment->user_id, $commentUser->id);
        $this->assertEquals($comment->photo_post_id, $pP->id);
    }
}
