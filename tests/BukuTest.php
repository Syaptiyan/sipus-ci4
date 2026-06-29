<?php

namespace Tests;

use CodeIgniter\Test\CIUnitTestCase;

class BukuTest extends CIUnitTestCase
{
    public function testBukuIndexReturns200()
    {
        $result = $this->call('GET', '/buku');
        $this->assertResponseStatusCode(200);
    }

    public function testBukuShowReturns200()
    {
        $result = $this->call('GET', '/buku/1');
        $this->assertResponseStatusCode(200);
    }

    public function testApiBukuRequiresToken()
    {
        $result = $this->call('GET', '/api/buku');
        $this->assertResponseStatusCode(401);
    }

    public function testLoginReturns200()
    {
        $result = $this->call('GET', '/login');
        $this->assertResponseStatusCode(200);
    }

    public function testLandingPageReturns200()
    {
        $result = $this->call('GET', '/');
        $this->assertResponseStatusCode(200);
    }
}
