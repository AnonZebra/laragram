<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

/**
 * Various tests closely related to user login/logout and registration.
 */
class AuthTest extends TestCase
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
    }

    /**
     * Visiting profile URL redirects non-logged in user
     * to login screen.
     */
    public function testUnauthRedirect()
    {
        $response = $this->get('/profile');

        $response
            ->assertStatus(302)
            ->assertRedirect(route('guest.showLogin'));
    }

    /**
     * Visiting profile URL as logged in user
     * returns profile view.
     */
    public function testAuthHome()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response
            ->assertStatus(200)
            ->assertViewIs('profile');
    }

    /**
     * POSTing to logout route as logged in user
     * makes the session unauthenticated/logged out, and
     * reroutes user to login screen.
     */
    public function testLogout()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        // ensure that acting as user really does qualify the session
        // as being authenticated
        $this->assertAuthenticated();

        $response = $this->post(route('user.processLogout'));
        $this->assertGuest();

        $response
            ->assertStatus(302)
            ->assertRedirect(route('guest.showLogin'));
    }

    /**
     * POSTing to login route with valid credentials
     * makes the session authenticated/logged in,
     * and redirects user to home route.
     */
    public function testLogin()
    {
        $userInfo = $this->userInfo;

        $user = User::create([
            'name' => $userInfo['name'],
            'email' => $userInfo['email'],
            'password' => bcrypt($userInfo['password']),
        ]);

        $response = $this
            ->post(route('guest.processLogin'), [
                'email' => $userInfo['email'],
                'password' => $userInfo['password']
            ]);

        $this->assertAuthenticated();

        $response
            ->assertStatus(302)
            ->assertRedirect(route('user.profile'));
    }

    /**
     * POSTing to login route with invalid credentials
     * redirects user to root route (since there is no
     * other route to send user 'back to').
     */
    public function testNonExistingUserLogin()
    {
        $userInfo = $this->userInfo;

        $response = $this
            ->post(route('guest.processLogin'), [
                'email' => $userInfo['email'],
                'password' => $userInfo['password']
            ]);

        $this->assertGuest();

        $response
            ->assertStatus(302)
            ->assertRedirect('/');
    }

    /**
     * POSTing to login route with valid username but
     * invalid password six times locks the user account
     * temporarily.
     */
    public function testWrongPassBlockLogin()
    {
        $userInfo = $this->userInfo;

        $user = User::create([
            'name' => $userInfo['name'],
            'email' => $userInfo['email'],
            'password' => bcrypt($userInfo['password']),
        ]);

        for ($i = 0; $i < 6; $i++) {
            $response = $this->post(
                route('guest.processLogin'),
                [
                    'email' => $userInfo['email'],
                    'password' => 'wrong_pass'
                ]
            );
        }

        $dbUser = User::where('email', $userInfo['email'])->first();

        $this->assertGuest();
        $this->assertTrue($dbUser->locked_flag);

        $this->assertEquals($dbUser->error_count, 6);
    }

    /**
     * POSTing to registration route with valid credentials
     * creates a new user.
     */
    public function testRegister()
    {
        $userInfo = $this->userInfo;

        $user = User::create([
            'name' => $userInfo['name'],
            'email' => $userInfo['email'],
            'password' => bcrypt($userInfo['password']),
        ]);

        $response = $this
            ->post(route('guest.processLogin'), [
                'email' => $userInfo['email'],
                'password' => $userInfo['password']
            ]);

        $this->assertAuthenticated();

        $response
            ->assertStatus(302)
            ->assertRedirect(route('user.profile'));
    }

    /**
     * Visiting registration URL as guest
     * returns form view.
     */
    public function testUnauthShowRegister()
    {
        $response = $this
            ->get(route('guest.showRegistration'));

        $response
            ->assertStatus(200)
            ->assertViewIs('register.register_form');
    }
}
