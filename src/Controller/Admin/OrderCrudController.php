<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Form\OrderItemType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            AssociationField::new('idUser', 'User'),
            ChoiceField::new('status', 'Status')
                ->setChoices([
                    'CANCELED' => 'CANCELED',
                    'RECEIVED' => 'RECEIVED',
                    'DELIVERED' => 'DELIVERED',
                ]),
            MoneyField::new('totalAmount', 'Total Amount')
                ->setCurrency('EUR')
                ->hideOnForm(),
            DateField::new('orderDate', 'Order Date'),
            CollectionField::new('orderItems', 'Items')
                ->setEntryType(OrderItemType::class)
                ->allowAdd()
                ->allowDelete(),
        ];
    }
}
