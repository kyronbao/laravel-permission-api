<?php

namespace Tests;

use Admin\Models\Stuff;


class StuffTest extends TestCase
{

    public function testStuffRegisterTest()
    {
        Stuff::where('username', 'bbbb')->delete();

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
