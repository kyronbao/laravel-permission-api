<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

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

        $response->assertJson(OUTPUT_OK);

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

        $response->assertJson(OUTPUT_LOGGED_IN);

        $response->assertCookie('admin_token');
    }

}
