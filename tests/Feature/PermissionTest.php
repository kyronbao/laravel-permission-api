<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionTest extends TestCase
{

    use RefreshDatabase;

    /**
     * 其他测试用例如
     * test_post_roles,
     * test_get_menus,
     * test_post_munes
     * 由于逻辑大体相同，所以不写测试了
     *
     */


    public function test_get_roles()
    {
        factory(\Admin\Models\Stuff::class)->create();
        $response = $this->call('GET', 'admin/get-roles', [], [
            'admin_token' => md5(123456)
        ]);
        $response->assertJson(OUTPUT_OK);
    }
}
