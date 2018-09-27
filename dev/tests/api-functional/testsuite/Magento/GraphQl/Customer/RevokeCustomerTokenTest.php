<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\GraphQl\Customer;

use Magento\TestFramework\ObjectManager;
use Magento\TestFramework\TestCase\GraphQlAbstract;

/**
 * Test for revoke customer token mutation
 */
class RevokeCustomerTokenTest extends GraphQlAbstract
{



    public function testRevokeCustomerTokenForLoggedCustomers()
    {


        $query = <<<QUERY
            mutation {
                revokeCustomerToken
            }
QUERY
        ;

        $userName = 'customer@example.com';
        $password = 'password';
        /** @var CustomerTokenServiceInterface $customerTokenService */
        $customerTokenService = ObjectManager::getInstance()
            ->get(\Magento\Integration\Api\CustomerTokenServiceInterface::class);
        $customerToken = $customerTokenService->createCustomerAccessToken($userName, $password);

        $headerMap = ['Authorization' => 'Bearer ' . $customerToken];

        $response = $this->graphQlQuery($query, [], '', $headerMap);

        self::assertTrue($response);
    }


    public function testRevokeCustomerTokenForGuestCustomer()
    {
        $query = <<<MUTATION
            mutation {
                revokeCustomerToken
            }
MUTATION;

        $response = $this->graphQlQuery($query, [], '');
        $this->expectException($response);
    }


}
