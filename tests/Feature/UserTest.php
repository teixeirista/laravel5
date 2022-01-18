<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /** @test  */
    public function login_successfull()
    {
        $response = $this->get('/home')->assertRedirect('/login');
    }

    /** @test  */
    public function only_logged_users_can_see_files_list()
    {
        $response = $this->get('/home')->assertRedirect('/login');
    }
}
