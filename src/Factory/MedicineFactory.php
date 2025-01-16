<?php

namespace App\Factory;

use App\Entity\Medicine;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Medicine>
 */
final class MedicineFactory extends PersistentProxyObjectFactory
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
        return Medicine::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'dosage' => self::faker()->randomElement(['2 fois par jour', '3 fois par semaines', 'Tous les matins']),
            'priceUnit' => self::faker()->randomFloat(2, 4.99, 39.99),
            'type' => self::faker()->randomElement(['Gélule', 'Comprimé', 'Sirop']),
            'quantity' => self::faker()->randomNumber(2),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Medicine $medicine): void {})
        ;
    }
}
