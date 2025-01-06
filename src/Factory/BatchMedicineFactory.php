<?php

namespace App\Factory;

use App\Entity\BatchMedicine;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<BatchMedicine>
 */
final class BatchMedicineFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return BatchMedicine::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'arrivalDate' => self::faker()->dateTime(),
            'expirationDate' => self::faker()->dateTime(),
            'purchasePrice' => self::faker()->randomFloat(2, 0, 999.99),
            'quantity' => self::faker()->randomNumber(),
            'stock' => self::faker()->randomNumber(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(BatchMedicineFixtures $batchMedicine): void {})
        ;
    }
}
