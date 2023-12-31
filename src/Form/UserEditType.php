<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('cedula')
            ->add('Nombre')
            ->add('Apellido')
            ->add('Profesion')
            ->add('image',FileType::class,[
                'label'=> 'Imagen',
                'mapped' => false,
 
                 // make it optional so you don't have to re-upload the PDF file
                 // every time you edit the Product details
                 'required' => false,
 
                 // unmapped fields can't define their validation using annotations
                 // in the associated entity, so you can use the PHP constraint classes
                 'constraints' => [
                     new File([
                         'maxSize' => '250k',
                         'mimeTypes' => [
                             'image/jpeg',
                             'image/png',
                         ],
                         'mimeTypesMessage' => 'Porfavor cargar imagen con formato png o jpg',
                     ])
                 ],
                
             ])
             
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
