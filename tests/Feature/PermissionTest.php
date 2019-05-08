<?php

namespace Tests\Feature;

use App\Exceptions\Err;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionTest extends TestCase
{

    use RefreshDatabase;

    /**
     * TODO 测试用例
     */

    public function test_get_roles()
    {
        factory(\Admin\Models\Stuff::class)->create();
        $response = $this->call('GET', 'admin/auth/get-roles', [], [
            'admin_token' => 'token_string',
        ]);
        $response->assertJson(Err::AUTH_FORBIDDEN);
    }
}
