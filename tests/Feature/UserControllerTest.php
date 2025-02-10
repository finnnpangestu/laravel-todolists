<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')->assertSeeText('Login');
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            "user" => "username",
        ])->get('/login')->assertRedirect('/');
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            'user' => 'username',
            'password' => 'password'
        ])->assertRedirect('/')->assertSessionHas('user', 'username');
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            'user'=> 'username',
        ])->post('/login', [
            'user' => 'username',
            'password' => 'password'
        ])->assertRedirect('/');
    }

    public function testLoginValidationError()
    {
        $this->post('/login', [])->assertSeeText('User and password must be filled');
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            'user'=> 'tukimin',
            'password'=> 'tuikmin'
        ])->assertSeeText('User or password is wrong');
    }

    
    public function testLogoutSuccess()
    {
        $this->withSession([
            "user" => "username"
        ])->post('/logout')->assertRedirect('/')->assertSessionMissing('user');
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')->assertRedirect('/login');
    }
}