<?php

namespace App\DataFixtures;

use App\Entity\DisplayPreset;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class DisplayPresetFixtures
 * @package App\DataFixtures
 */
class DisplayPresetFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $symfonyPreset = new DisplayPreset();
        $symfonyPreset
            ->setName('Symfony')
            ->setDescription('Visualize your profiled data for the symfony framework')
            ->setConfig([]);

        $this->addReference('symfony-preset', $symfonyPreset);

        $manager->persist($symfonyPreset);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}
