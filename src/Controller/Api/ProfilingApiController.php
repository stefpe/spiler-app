<?php

namespace App\Controller\Api;

use App\Entity\Profile;
use App\Security\Api\ApiUser;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProfilingApiController
 * @package AppBundle\Controller\Api
 */
class ProfilingApiController extends Controller
{

    /**
     * Persist a profiling result.
     *
     * @Route("/profile", name="api_profiling")
     * @Method("POST")
     */
    public function profilingAction(Request $request, EntityManager $em)
    {
        $data = json_decode(str_replace("\\","\\\\", $request->getContent()), true);

        if(!$data){
            return new JsonResponse('error parsing given json', Response::HTTP_NOT_ACCEPTABLE);
        }

        /** @var ApiUser $user */
        $user = $this->getUser();

        $profile = new Profile();
        $profile
                ->setData($data)
                ->setApplication($user->getApplication())
                ->setCreated(new \DateTime())
                ->setType($data['sn'] ?? '');

        try {
            $em->persist($profile);
            $em->flush();
            return new JsonResponse('success');
        }catch (\Exception $e){
            return new JsonResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
