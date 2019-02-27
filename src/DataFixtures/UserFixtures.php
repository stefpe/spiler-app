<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixtures
 * @package App\DataFixtures
 */
class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setEmail('test@example.com')
            ->setPassword($this->encoder->encodePassword($user, 'test1234'))
            ->addRole($this->getReference('user-role'))
            ->setExpiration(new \DateTime('+5 years'))
            ->setActive(true);

        $this->addReference('user-test', $user);

        $manager->persist($user);

        $manager->flush();
    }


    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}
