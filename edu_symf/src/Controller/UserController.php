<?php

namespace App\Controller;

use App\Entity\Users;
use Composer\Util\Http\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class UserController extends AbstractController
{
//    #[Route('/user', name: 'app_user')]
//    public function index(): JsonResponse
//    {
//        return $this->json([
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/UserController.php',
//        ]);
//    }

    #[Route('/user', name: 'create_user')]
    public function createUser(ManagerRegistry $doctrine) : JsonResponse
    {
        $entityManager = $doctrine->getManager();

        $user = new Users();
        $user->setFirstname('Gennadiy');
        $user->setLastname('Korshunov');
        $user->setId(Uuid::v1());
        $entityManager->persist($user);

        $entityManager->flush();

        return new JsonResponse(
            'Saved new user with id' . $user->getId(),
            status: 200);
    }
}
