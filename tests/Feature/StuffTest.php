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
            'username' => 'bbbb'
        ]);

        $response = $this->post('/admin/login', [
            'username'  => 'bbbb',
            'user'      => 'Jim',
            'password'  => '123456'
        ]);

        $response->assertJson(Err::OUTPUT_OK);

        $response->assertCookie('admin_token');

        $this->assertDatabaseHas('stuffs', [
            'username' => 'bbbb'
        ]);
    }

    public function test_login_with_username_password()
    {
        factory(\Admin\Models\Stuff::class)->create();

        $response = $this->post('/admin/login', [
            'username' => 'bbbb',
            'user' => 'Jim',
            'password' => '123456'
        ]);

        $response->assertJson(Err::OUTPUT_OK);

        $response->assertCookie('admin_token');
    }

    public function test_get_stuff_info_with_cookie()
    {
        factory(\Admin\Models\Stuff::class)->create();
        $response = $this->call('GET', '/admin/stuff', [], [
            'admin_token' => md5(123456)
        ]);
        $response->assertJson(Err::OUTPUT_OK);

    }

    public function test_cannot_get_stuff_info_without_cookie()
    {
        factory(\Admin\Models\Stuff::class)->create();
        $response = $this->call('GET', '/admin/stuff');
        $response->assertJson(Err::AUTH_NOT_LOGGED);
    }


}
