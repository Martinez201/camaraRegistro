<?php


namespace AppBundle\Form\Type;


use AppBundle\Entity\Empleados;
use AppBundle\Form\Model\InformeModel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InformeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaPrincipio',DateType::class,[

                'label'=> 'Fecha Inicial:'

            ])
            ->add('fechaFinal', DateType::class,[

                'label'=>'Fecha Final:'

            ])
            ->add('empleado', EntityType::class ,[

                'label'=>'Empleado:',
                'required'=> false,
                'class'=> Empleados::class,
                'placeholder'=>'<- Seleccione Empleado ->'


            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class'=> InformeModel::class

        ]);
    }


}