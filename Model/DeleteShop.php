<?php

declare(strict_types=1);

namespace Saddemlabidi\ShopfinderRest\Model;

use Magento\Framework\Webapi\Exception;

class DeleteShop
{
    /**
     * Delete shop by ID - always throws an exception.
     *
     * @param int $id
     * @return void
     * @throws Exception
     */
    public function delete(int $id): void
    {
        throw new Exception(
            __('Deleting shops via REST API is not allowed.'),
            0,
            Exception::HTTP_METHOD_NOT_ALLOWED
        );
    }
}
