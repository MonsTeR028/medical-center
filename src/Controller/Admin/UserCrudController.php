<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('Email'),
            TextField::new('Password')->onlyOnForms()
                ->setFormType(PasswordType::class)
                ->setRequired(false)
                ->setEmptyData('')
                ->setCustomOption('autocomplete', 'new-password'),
            TextField::new('FirstName'),
            TextField::new('LastName'),
            ArrayField::new('Roles')->formatValue(function ($value) {
                if (in_array('ROLE_ADMIN', $value)) {
                    return '<span class="material-symbols-outlined">manage_accounts</span>';
                } elseif (in_array('ROLE_USER', $value)) {
                    return '<span class="material-symbols-outlined">person</span>';
                } else {
                    return '';
                }
            }),
        ];
    }
    */
}
