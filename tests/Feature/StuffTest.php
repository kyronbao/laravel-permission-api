<?php

namespace Tests\Feature;

use App\Exceptions\Err;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StuffTest extends TestCase
{

    use RefreshDatabase;

    public function test_stuff_register()
    {
        $this->assertDatabaseMissing('stuffs', [
            'username' => 'kyronbao'
        ]);

        $response = $this->post('/admin/auth/register', [
            'username' => 'kyronbao',
            'email' => 'kyronbao@gmail.com',
            'password' => '12345678'
        ]);

        $response->assertJsonFragment(['username' => 'kyronbao']);

        $response->assertCookie('admin_token');

        $this->assertDatabaseHas('stuffs', [
            'username' => 'kyronbao'
        ]);
    }

    public function test_login_with_username_password()
    {
        factory(\Admin\Models\Stuff::class)->create();

        $response = $this->post('/admin/auth/login', [
            'username' => 'kyronbao',
            'password' => '12345678'
        ]);

        $response->assertJsonFragment(['username' => 'kyronbao']);

        $response->assertCookie('admin_token');
    }

    public function test_get_stuff_info_with_cookie()
    {
        factory(\Admin\Models\Stuff::class)->create();
        $response = $this->call('GET', '/admin/auth/stuff', [], [
            'admin_token' => 'token_string'
        ]);
        $response->assertJson(Err::OUTPUT_OK);

    }

    public function test_cannot_get_stuff_info_without_cookie()
    {
        factory(\Admin\Models\Stuff::class)->create();
        $response = $this->call('GET', '/admin/auth/stuff');
        $response->assertJson(Err::AUTH_NOT_LOGGED);
    }

    public function test_logout()
    {
        factory(\Admin\Models\Stuff::class)->create();
        $response = $this->call('POST', '/admin/auth/logout', [], [
            'admin_token' => 'token_string'
        ]);
        $response->assertJson(Err::OUTPUT_OK);
    }

    public function test_cannot_logout_without_cookie()
    {
        factory(\Admin\Models\Stuff::class)->create();
        $response = $this->call('POST', '/admin/auth/logout');
        $response->assertJson(Err::AUTH_NOT_LOGGED);
    }


}
