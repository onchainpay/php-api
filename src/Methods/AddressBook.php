<?php namespace OnChainPay\Methods;

use OnChainPay\Exception;
use OnChainPay\Extends\Method;

class AddressBook extends Method
{
    /**
     * Adding a new address to the address book
     * @param string $organizationId Organization ID
     * @param string $address The address in the blockchain
     * @param string[] $networks List of address networks
     * @param string $alias Address name
     * @param string $comment Comment on the address
     * @return array
     * @throws Exception
     */
    public function add(string $organizationId, string $address, array $networks, string $alias, string $comment): array
    {
        return $this->instance->request('address-book/add', compact('organizationId', 'address', 'networks', 'alias', 'comment'));
    }

    /**
     * Deleting an address from the address book
     * @param string $addressId The ID of the address in the system
     * @return array
     * @throws Exception
     */
    public function delete(string $addressId): array
    {
        return $this->instance->request('address-book/remove', compact('addressId'));
    }

    /**
     * Updating information at
     * @param string $organizationId Organization ID
     * @param string $addressId The ID of the address in the system
     * @param string $alias Address name
     * @param string $comment Comment on the address
     * @return array
     * @throws Exception
     */
    public function update(string $organizationId, string $addressId, string $alias, string $comment): array
    {
        return $this->instance->request('address-book/update', compact('organizationId', 'addressId', 'alias', 'comment'));
    }

    /**
     * Getting a list of addresses
     * @param string $organizationId Organization ID
     * @param int $limit Number of elements per page
     * @param int $offset Number of items to skip
     * @param string[]|null $networks List of networks to search for addresses in
     * @return array
     * @throws Exception
     */
    public function get(string $organizationId, int $limit = 100, int $offset = 0, array $networks = null): array
    {
        return $this->instance->request('address-book/get', compact('organizationId', 'limit', 'offset', 'networks'));
    }
}
