<?php

declare(strict_types=1);

use Magento\Framework\Webapi\Exception;
namespace Saddemlabidi\ShopfinderRest\Api;

interface DeleteShopInterface
{
    /**
     * Delete shop by ID - always throws an exception.
     *
     * @param int $id
     * @return void
     * @throws Exception
     */
    public function delete(int $id): void;
}