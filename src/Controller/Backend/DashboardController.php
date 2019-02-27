<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 2019-02-27
 * Time: 17:19
 */

namespace App\Controller\Backend;


use App\Entity\Application;
use App\Repository\ProfileRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class DashboardController
 * @package App\Controller\Backend
 */
class DashboardController
{
    /**
     * @var ProfileRepository;
     */
    private $profileRepository;

    /**
     * DashboardController constructor.
     * @param ProfileRepository $profileRepository
     */
    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }


    /**
     * @Route("/dashboard", name="backend_dashboard", methods={"GET"})
     */
    public function indexAction()
    {
        $userId = $this->getUser()->getId();
        $repo = $this->getDoctrine()->getManager()->getRepository(Application::class);
        $applications = $repo->findBy(['user' => $userId]);
        $cntProfiles = $this->profileRepository->getProfilesCountByUser($this->getUser()->getId(), (int)date('m'));
        $recentProfiles = $this->profileRepository
            ->getProfilesByUserQueryBuilder($userId)
            ->orderBy('profile.created', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->execute();

        return $this->render('AppBundle:dashboard:index.html.twig', [
            'applicationCnt' => count($applications),
            'profilesCnt' => $cntProfiles,
            'recentProfiles' => $recentProfiles,
            'currentMonth' => date('F')
        ]);
    }
}
