<?php

namespace App\Form;

use App\Entity\Paciente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Range;

class PacienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nombre')
            ->add('Apellido')
            ->add('image_profile',FileType::class,[
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
            ->add('Sexo',ChoiceType::class,[
                'placeholder'=>'Seleccione sexo',
                'choices'=>[
                 'Hombre' => 'Hombre',
                 'Mujer' => 'Mujer',
                ]
            ])
            ->add('fecha_nacimiento',BirthdayType::class,[
                'label'=>'Fecha de Nacimiento',
                'years' => range(1930, date("Y")),
                'constraints' => new Range(['max'=>"now"]),
                'placeholder' => [
                    'year' => 'Año', 'month' => 'Mes', 'day' => 'Dia',
                ]
            ])
            ->add('cedula')
            ->add('fecha_ingreso',BirthdayType::class,[
                'label'=>'Fecha de Ingreso al Trabajo', 
                'years' => range(2000, date("Y")),
                'constraints' => new Range(['max'=>"now"]),
                'placeholder' => [
                    'year' => 'Año', 'month' => 'Mes', 'day' => 'Dia'
                   
                ]
            ])
         
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Paciente::class,
        ]);
    }
}
