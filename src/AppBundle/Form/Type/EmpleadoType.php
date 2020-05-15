<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Empleados;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpleadoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
           $builder
               ->add('nombre', TextType::class,[

                   'label'=> 'Nombre:'
               ])
               ->add('apellidos', TextType::class,[

                   'label'=> 'Apellidos:'
               ])
               ->add('dni', TextType::class,[

                   'label'=> 'D.N.I:'

               ])
               ->add('email',TextType::class,[

                   'label'=>'Email:'
               ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class'=> Empleados::class

        ]);
    }


}