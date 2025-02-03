<?php

declare(strict_types=1);

namespace Saddemlabidi\ShopfinderRest\Api;

use Magento\Framework\Webapi\Exception;

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