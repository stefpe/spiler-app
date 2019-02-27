<?php

namespace App\DataFixtures;

use App\Components\UniqueIdGenerator;
use App\Entity\Application;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ApplicationFixtures
 * @package App\DataFixtures
 */
class ApplicationFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $spilerApp = new Application();
        $spilerApp
            ->setName('Spiler')
            ->setDescription('Profiling Application Backend')
            ->setApiKey((new UniqueIdGenerator())->generateUniqueId())
            ->setDisplayPreset($this->getReference('symfony-preset'))
            ->setUser($this->getReference('user-test'));

        $this->addReference('spiler-app', $spilerApp);

        $manager->persist($spilerApp);
        $manager->flush();
        $manager->flush();
    }


    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}
