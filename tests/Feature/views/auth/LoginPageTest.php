<?php

namespace Tests\Feature\views\auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginPageTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->user = factory(User::class)->create([
            'role_id' => config('const.seeder.role_id'),
        ]);
    }

    public function test_user_can_navigate_login_page()
    {
        $response = $this->get('/login');

        $response->assertSee(trans('messages.login'));
        $response->assertSee(trans('messages.input_form.remember_me'));
        $response->assertSee(trans('messages.input_form.forgot_password'));
    }

    public function test_it_can_login_with_valid_user()
    {
        $user = $this->user;
        $validUser = [
            '_token' => csrf_token(),
            'email' => $user->email,
            'password' => $user->password,
        ];
        $response = $this->post('/login', $validUser);

        $response->assertStatus(302);
        $response->assertRedirect(route('homepage'));
    }

    public function test_it_cannot_login_with_invalid_user()
    {
        $user = $this->user;
        $invalidUser = [
            '_token' => csrf_token(),
            'email' => $user->email,
            'password' => '@@',
        ];
        $response = $this->json('POST', '/login', $invalidUser);

        $response->assertStatus(422);
        $response->assertSee(trans('auth.failed'));
    }
}