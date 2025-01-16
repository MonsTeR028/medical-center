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
        return function () {
            $arrivalDate = self::faker()->dateTime();
            $expirationDate = self::faker()->dateTimeBetween($arrivalDate, '+2 years');

            return [
                'arrivalDate' => $arrivalDate,
                'expirationDate' => $expirationDate,
                'purchasePrice' => self::faker()->randomFloat(2, 4.99, 39.99),
            ];
        };
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
