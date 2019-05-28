<?php
namespace tests;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use fileUploader\ApiController;
use fileUploader\Adapter;

class FileUploadTest extends TestCase
{
    protected function setUp(): void
    {
        $this->http = new Client(['base_uri' => 'http://localhost:8888']);
    }

    protected function tearDown(): void
    {
        unset($_FILES);
        unset($this->object);
        @unlink(__DIR__ . '/map.jpg');
    }

    public function testStoreFile()
    {
        $_FILES = array(
            'test' => array(
                'name' => 'test.jpg',
                'type' => 'image/jpeg',
                'size' => 542,
                'tmp_name' => __DIR__ . '/map.jpg',
                'error' => 0
            )
        );

        $response = $this->http->request('GET', 'getlist');
        // var_dump($response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }
}