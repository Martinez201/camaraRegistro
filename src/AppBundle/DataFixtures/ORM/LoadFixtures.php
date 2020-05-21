<?php


namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Usuarios;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoadFixtures extends Fixture
{
    private  $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $objects = Fixtures::load(__DIR__.'/fixtures.yml',$manager,[

            'providers' => [$this]

        ]);
    }

    public function codificarClave($cadena){

        return $this->encoder->encodePassword(new Usuarios() , $cadena);
    }

}