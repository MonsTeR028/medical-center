<?php

namespace App\Form;

use App\Entity\User;
use App\Repository\MedicineCategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    private MedicineCategoryRepository $medicineCategoryRepository;

    public function __construct(MedicineCategoryRepository $medicineCategoryRepository)
    {
        $this->medicineCategoryRepository = $medicineCategoryRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['empty_data' => ''])
            ->add('password', PasswordType::class, ['empty_data' => ''])
            ->add('firstname', \Symfony\Component\Form\Extension\Core\Type\TextType::class, ['empty_data' => ''])
            ->add('lastname', \Symfony\Component\Form\Extension\Core\Type\TextType::class, ['empty_data' => ''])
            ->add('tel', \Symfony\Component\Form\Extension\Core\Type\TextType::class, ['empty_data' => ''])
            ->add('RRPS', \Symfony\Component\Form\Extension\Core\Type\TextType::class, ['empty_data' => ''])
            ->add('category', \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class, [
                'choices' => $this->medicineCategoryRepository->findAll(),
                'choice_label' => 'name',
                'choice_value' => 'id',
                'empty_data' => '',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
