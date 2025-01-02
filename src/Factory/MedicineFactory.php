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
            'dosage' => self::faker()->text(10),
            'priceUnit' => self::faker()->randomFloat(),
            'type' => self::faker()->randomElement(['Gélule', 'Comprimé', 'Sirop']),
            'imageFileName' => self::faker()->imageUrl(),
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
