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
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
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
                'Orale (per os)' => 'oral',
                'Sublinguale' => 'sublingual',
                'Rectale' => 'rectal',
                'Intraveineuse (IV)' => 'intravenous',
                'Intramusculaire (IM)' => 'intramuscular',
                'Sous-cutanée (SC)' => 'subcutaneous',
                'Transdermique' => 'transdermal',
                'Cutanée' => 'cutaneous',
                'Oculaire (ophtalmique)' => 'ocular',
                'Auriculaire (otic)' => 'auricular',
                'Nasale' => 'nasal',
                'Vaginale' => 'vaginal',
                'Pulmonaire (inhalation)' => 'pulmonary',
                'Intra-artérielle' => 'intra-arterial',
                'Intra-articulaire' => 'intra-articular',
                'Intrathécale' => 'intrathecal',
                'Péridurale' => 'epidural',
                'Intradermique' => 'intradermal',
                'Buccale' => 'buccal',
                'Intranasale' => 'intranasal',
                'Intraoculaire' => 'intraocular',
                'Intrapéritonéale' => 'intraperitoneal',
                'Intraosseuse' => 'intraosseous',
                ]),
            TextField::new('dosage', 'Dosage'),
            MoneyField::new('priceUnit', 'Prix unitaire')
                ->setCurrency('EUR'),
            TextareaField::new('description', 'Descriptif')
                ->hideOnIndex(),
            AssociationField::new('category', 'Catégories')
                ->setFormTypeOption('by_reference', false)
                ->setFormTypeOption('choice_label', 'name'),
        ];
    }
}
