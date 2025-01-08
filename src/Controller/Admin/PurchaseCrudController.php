<?php

namespace App\Controller\Admin;

use App\Entity\Purchase;
use App\Form\PurchaseItemType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class PurchaseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Purchase::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->hideOnForm(),
            AssociationField::new('idSupp', 'Supplier'),
            MoneyField::new('totalAmount', 'Total Amount')
                ->hideOnForm()
                ->setCurrency('EUR'),
            CollectionField::new('purchaseItems', 'Items')
                ->setEntryType(PurchaseItemType::class)
                ->allowAdd()
                ->allowDelete(),
        ];
    }
}
