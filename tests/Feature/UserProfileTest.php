<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserProfile;

class UserProfileTest extends TestCase
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
     * When a new user is created, an associated user profile
     * (record) is automatically created.
     */
    public function testAutomaticGeneration()
    {
        $user = User::factory()->create();

        $numMatch = UserProfile::where('user_id', $user->id)->count();

        $this->assertEquals($numMatch, 1);
    }

    /**
     * A user is able to update their own profile by POSTing
     * to the corresponding route with image+description,
     * whereupon the user is redirected,
     * the description and image paths are updated in the database,
     * and the uploaded image is stored.
     */
    // these were helpful in figuring out how to write the test:
    // https://ryu022304.hatenablog.com/entry/2020/06/30/Laravelでファイルのアップロード・ダウンロードのテ
    // https://qiita.com/tkek321/items/d3bd3f706fd9d2f0d72e
    // as the second article mentions, I had to change Storage::fake, in my case
    // from `Storage::fake('public');` to `Storage::fake('profiles');`. I'm still not
    // entirely sure why.
    public function testUpdateProfile()
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
        $description = "It's-a me, Mario!";

        $this->actingAs($user);
        $response = $this->post(route('user.processUpdateProfile'), [
            'image' => $file,
            'description' => $description
        ]);

        $updatedDesc = UserProfile::where('user_id', $user->id)->first()->description;

        //description updated
        $this->assertEquals($updatedDesc, $description);
        // redirected
        $response->assertStatus(302);
        // image saved
        Storage::disk('public')
            ->assertExists(
                'images/foo_example_com/' . $file->name
            );
    }

    /**
     * A user is able to update their own profile by POSTing
     * to the corresponding route with just description,
     * whereupon the user is redirected
     * and the description is updated in the database.
     */
    public function testUpdateProfileOnlyDescription()
    {
        $user = $this->randomUser;
        $description = "It's-a me, Mario!";

        $this->actingAs($user);
        $response = $this->post(route('user.processUpdateProfile'), [
            'description' => $description
        ]);

        $updatedDesc = UserProfile::where('user_id', $user->id)->first()->description;

        //description updated
        $this->assertEquals($updatedDesc, $description);
        // redirected
        $response->assertStatus(302);
    }
}
