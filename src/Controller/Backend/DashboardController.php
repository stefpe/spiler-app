<?php declare(strict_types=1);

namespace App\Controller\Backend;

use App\Entity\Application;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @package App\Controller\Backend
 */
class DashboardController extends AbstractController
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
     * @Route("/backend/dashboard", name="backend_dashboard", methods={"GET"})
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

        return $this->render('dashboard/index.html.twig', [
            'applicationCnt' => count($applications),
            'profilesCnt' => $cntProfiles,
            'recentProfiles' => $recentProfiles,
            'currentMonth' => date('F')
        ]);
    }
}
