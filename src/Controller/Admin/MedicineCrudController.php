<?php

namespace App\Controller\Admin;

use App\Entity\Medicine;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MedicineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Medicine::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom du médicament'),
            ChoiceField::new('type', 'Type')->setChoices([
                'Comprimés' => 'tablets',
                'Sirop' => 'syrup',
                'Gélules' => 'capsules',
                'Pilules' => 'pills',
                'Pommade' => 'ointment',
                'Crème' => 'cream',
                'Gel' => 'gel',
                'Spray' => 'spray',
                'Patch' => 'patch',
                'Solution injectable' => 'injectable_solution',
                'Suppositoire' => 'suppository',
                'Ovule' => 'vaginal_suppository',
                'Collyre' => 'eye_drops',
                'Gouttes auriculaires' => 'ear_drops',
                'Gouttes nasales' => 'nasal_drops',
                'Inhalateur' => 'inhaler',
                'Aérosol' => 'aerosol',
                'Nébuliseur' => 'nebulizer',
                'Poudre' => 'powder',
                'Granulés' => 'granules',
                'Liquide' => 'liquid',
                'Pastille' => 'lozenge',
                'Injectable' => 'injectable',
                'Bain de bouche' => 'mouthwash',
                'Shampoing médicamenteux' => 'medicated_shampoo',
                'Bandelette' => 'strip',
                'Résine' => 'resin',
                'Implant' => 'implant',
                'Solution buvable' => 'oral_solution',
                'Film orodispersible' => 'orodispersible_film',
            ]),
            TextField::new('dosage', 'Dosage'),
            MoneyField::new('priceUnit', 'Prix unitaire')
                ->setCurrency('EUR'),
            TextareaField::new('description', 'Descriptif')
                ->hideOnIndex(),
            AssociationField::new('category', 'Catégories')
                ->setFormTypeOption('choice_label', 'name'),
            ImageField::new('imageFileName', 'Image')
                ->setBasePath('/uploads/images')
                ->setUploadDir('public/uploads/images')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
        ];
    }
}
