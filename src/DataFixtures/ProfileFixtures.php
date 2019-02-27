<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ProfileFixtures
 * @package App\DataFixtures
 */
class ProfileFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $profile = new Profile();
        $profile
            ->setApplication($this->getReference('spiler-app'))
            ->setCreated(new \DateTime())
            ->setType('cli')
            ->setData(
                json_decode('{"type":"cli","start_time":1514210577974268.000000,"stop_time":1514210578110560.000000,"cpu_user_time":0.000000,"cpu_sys_time":20000.000000,"cnt_stack_items":10,"filename":"/opt/spiler/test.php","call_stack":[{"function_name":"test2","filename":"/opt/spiler/test.php","line_number":27,"memory_usage":9152,"start_time":1514210577974281.000000,"stop_time":1514210578104024.000000,"call_level":0},{"function_name":"test1","filename":"/opt/spiler/test.php","line_number":20,"memory_usage":384,"start_time":1514210577974285.000000,"stop_time":1514210578016432.000000,"call_level":1,"parent_index":0},{"function_name":"usleep","filename":"/opt/spiler/test.php","line_number":20,"memory_usage":0,"start_time":1514210577974288.000000,"stop_time":1514210578016414.000000,"call_level":2,"parent_index":1},{"function_name":"test3","filename":"/opt/spiler/test2.php","line_number":4,"memory_usage":0,"start_time":1514210578016425.000000,"stop_time":1514210578016429.000000,"call_level":2,"parent_index":1},{"function_name":"usleep","filename":"/opt/spiler/test.php","line_number":28,"memory_usage":0,"start_time":1514210578016436.000000,"stop_time":1514210578087299.000000,"call_level":1,"parent_index":0},{"function_name":"range","filename":"/opt/spiler/test.php","line_number":29,"memory_usage":33558720,"start_time":1514210578087315.000000,"stop_time":1514210578098970.000000,"call_level":1,"parent_index":0},{"function_name":"Test::tester","filename":"/opt/spiler/test.php","line_number":13,"memory_usage":384,"start_time":1514210578104044.000000,"stop_time":1514210578110544.000000,"call_level":0},{"function_name":"usleep","filename":"/opt/spiler/test.php","line_number":13,"memory_usage":0,"start_time":1514210578104048.000000,"stop_time":1514210578108039.000000,"call_level":1,"parent_index":6},{"function_name":"usleep","filename":"/opt/spiler/test.php","line_number":14,"memory_usage":0,"start_time":1514210578108047.000000,"stop_time":1514210578110536.000000,"call_level":1,"parent_index":6},{"function_name":"spiler_stop","filename":"/opt/spiler/test.php","line_number":45,"memory_usage":381728,"start_time":1514210578110555.000000,"stop_time":0.000000,"call_level":0}]}', true)
            );

        $manager->persist($profile);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 4;
    }
}
