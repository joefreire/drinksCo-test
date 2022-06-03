<?php
use App\Models\User;

class UserTest extends TestCase
{
    public function testCreateUser()
    {
        $user = User::where('email', 'test@json.com')->first();
        if (empty($user)) {
            $response = $this->call('POST', '/register', ['username' => 'TestJSON', 'email' => 'test@json.com', 'password' => 'teste1234']);
            $this->assertEquals(200, $response->status());
        }
        $this->seeInDatabase('users', ['email' => 'test@json.com']);
    }
    public function testFailCreateUser()
    {
        $response = $this->call('POST', '/register', ['username' => 'Test', 'email' => 'test', 'password' => 'teste1234']);
        $this->assertEquals(400, $response->status());
    }
}
