<?php

use Laravel\Lumen\Testing\DatabaseMigrations;

class ApiTest extends TestCase
{
    use DatabaseMigrations; // Reset db after each test so that data from a previous test does not interfere with subsequent tests

    /**
     * Test login.
     *
     * @return void
     */
    public function testLogin()
    {
        // Wrong credential
        $response = $this->call('POST', '/api/v1/auth/login',
            ['email' => 'random@gmail.com', 'password' => 'random']);
        $this->assertEquals(400, $response->status());

        // Correct credential
        $response = $this->call('POST', '/api/v1/auth/login',
            ['email' => 'admin@gmail.com', 'password' => '123456']);
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test get keyword statistics api without authenticated token.
     *
     * @return void
     */
    public function testGetKeywordStats()
    {
        $this->json('GET', '/api/v1/keyword-statistics')
            ->seeJson([
                'error' => 'Token not provided.',
            ]);
    }

    /**
     * Test get keyword statistics api with authenticated token.
     *
     * @return void
     */
    public function testGetKeywordStatsAuth()
    {
        $response = $this->call('POST', '/api/v1/auth/login',
            ['email' => 'admin@gmail.com', 'password' => 123456]);
        $this->assertEquals(200, $response->status());

        $token = $response->getData()->access_token;

        $this->json('GET', '/api/v1/keyword-statistics', [], ['HTTP_Authorization' => 'Bearer ' . $token])
            ->seeJson([
                'current_page' => 1,
            ]);
    }
}
