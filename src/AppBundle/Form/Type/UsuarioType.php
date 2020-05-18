<?php


namespace AppBundle\Form\Type;


use AppBundle\Entity\Empleados;
use AppBundle\Entity\Usuarios;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('empleado', EntityType::class,[

                'class'=> Empleados::class,
                'label'=>'Empleado',
                'placeholder'=> '<-Seleccione un empleado->'
            ])
            ->add('administrador', ChoiceType::class,[

                'label'=> 'Tipo Usuario:',
                'choices'=>[

                    'Administrador'=> true,
                    'Usuario'=> false
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class'=> Usuarios::class

        ]);
    }

}