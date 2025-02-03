<?php
declare(strict_types=1);

namespace Saddemlabidi\ShopfinderRest\Test\Integration;

use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Exception as WebapiException;

class ShopRestApiTest extends WebapiAbstract
{
    /**
     * Endpoint configuration for fetching all shops.
     */
    private const GET_ALL_SHOPS_SERVICE_INFO = [
        'rest' => [
            'resourcePath' => '/V1/shopfinder/shops',
            'httpMethod'   => 'GET'
        ]
    ];

    /**
     * Endpoint configuration for updating a shop.
     */
    private const UPDATE_SHOP_SERVICE_INFO = [
        'rest' => [
            'resourcePath' => '/V1/shopfinder/shop',
            'httpMethod'   => 'PUT'
        ]
    ];

    /**
     * Endpoint configuration for fetching a single shop by identifier.
     * Note: The placeholder ":identifier" is replaced in the test method.
     */
    private const GET_SHOP_BY_IDENTIFIER_SERVICE_INFO = [
        'rest' => [
            'resourcePath' => '/V1/shopfinder/shop/:identifier',
            'httpMethod'   => 'GET'
        ]
    ];

    /**
     * Endpoint configuration for deleting a shop.
     */
    private const DELETE_SHOP_SERVICE_INFO = [
        'rest' => [
            'resourcePath' => '/V1/shopfinder/shop/:id',
            'httpMethod'   => 'DELETE'
        ]
    ];

    /**
     * Test fetching all shops.
     */
    public function testGetAllShops(): void
    {
        $serviceInfo = self::GET_ALL_SHOPS_SERVICE_INFO;
        $response = $this->_webApiCall($serviceInfo);
        // Assert that response is an object with an items property (SearchResultsInterface structure)
        $this->assertIsArray($response->getItems(), 'Expected an array of shop items.');
    }

    /**
     * Test updating a shop.
     *
     * This test uses a known shop id. Adjust the shop id and input data according to your fixtures.
     */
    public function testUpdateShop(): void
    {
        $shopId = 1; // Adjust to an existing shop id in your test environment.
        $updateData = [
            'id'                 => $shopId,
            'identifier'         => 'shop-001-updated',
            'name'               => 'Updated Shop Name',
            'description'        => 'Updated Description',
            'country'            => 'USA',
            'image'              => 'updated-image.jpg',
            'longitude_latitude' => '40.7128,-74.0060'
        ];

        $serviceInfo = self::UPDATE_SHOP_SERVICE_INFO;
        $response = $this->_webApiCall($serviceInfo, ['data' => $updateData]);
        // Assert the shop id matches and the name was updated.
        $this->assertEquals($shopId, $response['id']);
        $this->assertEquals('Updated Shop Name', $response['name']);
    }

    /**
     * Test fetching a single shop by its identifier.
     *
     * Adjust the identifier value to match one in your test fixtures.
     */
    public function testGetShopByIdentifier(): void
    {
        $identifier = 'shop-001-updated'; // This should match the identifier from testUpdateShop.
        $serviceInfo = self::GET_SHOP_BY_IDENTIFIER_SERVICE_INFO;
        // Replace placeholder with actual identifier.
        $serviceInfo['rest']['resourcePath'] = str_replace(':identifier', $identifier, $serviceInfo['rest']['resourcePath']);

        $response = $this->_webApiCall($serviceInfo);
        $this->assertEquals($identifier, $response['identifier']);
        $this->assertArrayHasKey('name', $response);
    }

    /**
     * Test that deleting a shop via REST is not allowed.
     *
     * Expect a WebapiException with HTTP status code 403.
     */
    public function testDeleteShopNotAllowed(): void
    {
        $shopId = 1; // Use an existing shop id.
        $serviceInfo = self::DELETE_SHOP_SERVICE_INFO;
        $serviceInfo['rest']['resourcePath'] = str_replace(':id', (string)$shopId, $serviceInfo['rest']['resourcePath']);

        try {
            $this->_webApiCall($serviceInfo);
            $this->fail('Expected an exception when trying to delete a shop via REST.');
        } catch (WebapiException $e) {
            // Assert that the exception code corresponds to HTTP 403 Forbidden.
            $this->assertEquals(403, $e->getHttpCode());
            $this->assertStringContainsString('Deleting shops via REST API is not allowed', $e->getMessage());
        }
    }

    /**
     * Test fetching a shop by a non-existent identifier.
     *
     * Expect a WebapiException with HTTP status code 404.
     */
    public function testGetShopByIdentifierNotFound(): void
    {
        $identifier = 'non-existent-identifier';
        $serviceInfo = self::GET_SHOP_BY_IDENTIFIER_SERVICE_INFO;
        $serviceInfo['rest']['resourcePath'] = str_replace(':identifier', $identifier, $serviceInfo['rest']['resourcePath']);

        try {
            $this->_webApiCall($serviceInfo);
            $this->fail('Expected an exception when shop is not found.');
        } catch (WebapiException $e) {
            $this->assertEquals(404, $e->getHttpCode());
            $this->assertStringContainsString('No shop found for identifier', $e->getMessage());
        }
    }
}
