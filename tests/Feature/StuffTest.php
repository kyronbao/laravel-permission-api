<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

class StuffTest extends TestCase
{

    use RefreshDatabase;

    public function testStuffRegisterTest()
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

}
