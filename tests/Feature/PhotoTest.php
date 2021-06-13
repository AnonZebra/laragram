<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

use App\Models\User;
use App\Models\PhotoPost;

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

        $response = $this->get(
            route(
                'showPhotoList', 
                ['id' => $user->id]
            )
        );

        $response
            ->assertStatus(200);
    }
}
