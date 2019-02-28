<?php

namespace App\Controller\Backend;

use App\Components\DisplayPresets\DisplayPresetAdjusterFactory;
use App\Components\DisplayPresets\DisplayPresetAdjusterInterface;
use App\Entity\Profile;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Profile controller.
 *
 * @Route("/backend/profiles")
 */
class ProfileController extends Controller
{

    /**
     * @var ProfileRepository;
     */
    private $profileRepository;

    /**
     * ProfileController constructor.
     * @param ProfileRepository $profileRepository
     */
    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }


    /**
     * Lists all profile entities.
     *
     * @Route("/", name="profile_index", methods={"GET"})
     */
    public function indexAction()
    {
        $userId = $this->getUser()->getId();
        $qb = $this->profileRepository->getProfilesByUserQueryBuilder($userId);
        $profiles = $qb
            ->orderBy('profile.created', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->execute();

        return $this->render('profile/index.html.twig', array(
            'profiles' => $profiles
        ));
    }

    /**
     * Finds and displays a profile entity.
     *
     * @Route("/{id}/{type}", name="profile_show", defaults={"type"="timeline"})
     * @Method("GET")
     */
    public function showAction(Profile $profile, string $type)
    {
        $viewName = sprintf('profile/%s.html.twig', $type);

        /** @var DisplayPresetAdjusterInterface $displayPresetAdjuster */
        $displayPresetAdjuster = DisplayPresetAdjusterFactory::getDisplayPresetAdjuster(
            $profile->getApplication()->getDisplayPreset()->getName()
        );


        if ($type === 'timeline') {

            $data = $displayPresetAdjuster->getTimelineData($profile->getData());

            $profile->setData($data);
        }

        if ($type === 'flowgraph') {
            $profile->setData($displayPresetAdjuster->getFlowgraphData($profile->getData()));
        }

        return $this->render($viewName, array(
            'profile' => $profile,
            'type' => $type
        ));
    }
}
