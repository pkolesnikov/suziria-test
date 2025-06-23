<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

final class ProductTest extends TestCase
{
    private Client $client;

    protected function setUp(): void
    {
        $this->client = new Client([
            'base_uri' => 'http://app', 
            'http_errors' => false,
        ]);

    }

    public function testProductLifecycle(): void
    {
        // Create
        $res = $this->client->post('/products', [
            'json' => [
                'name' => 'Guzzle Phone',
                'price' => 999.99,
                'category' => 'electronics',
                'attributes' => ['brand' => 'Guzzle', 'color' => 'white']
            ]
        ]);
        $this->assertEquals(201, $res->getStatusCode());

        $body = json_decode($res->getBody(), true);
        $this->assertArrayHasKey('id', $body);
        $id = $body['id'];

        // Get
        $res = $this->client->get("/products/$id");
        $this->assertEquals(200, $res->getStatusCode());
        $product = json_decode($res->getBody(), true);
        $this->assertEquals('Guzzle Phone', $product['name']);

        // Patch
        $res = $this->client->patch("/products/$id", [
            'json' => ['price' => 888.88]
        ]);
        $this->assertEquals(200, $res->getStatusCode());

        // List
        $res = $this->client->get("/products?minPrice=500");
        $this->assertEquals(200, $res->getStatusCode());
        $list = json_decode($res->getBody(), true);
        $this->assertIsArray($list);
        $this->assertNotEmpty($list);

        // Delete
        $res = $this->client->delete("/products/$id");
        $this->assertEquals(204, $res->getStatusCode());

        // Get again (should be 404)
        $res = $this->client->get("/products/$id");
        $this->assertEquals(404, $res->getStatusCode());
    }
}
