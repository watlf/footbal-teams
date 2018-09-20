<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register", methods={"POST"})
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return JsonResponse
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        $username = $request->getUser();
        $password = $request->getPassword();

        $user = $em->getRepository('App:User')->findOneBy(['username' => $username]);

        if (!is_null($user)) {
            return $this->json(['error' => sprintf('User %s user already exists', $user->getUsername())], 409);
        }

        $user = new User($username);
        $user->setPassword($encoder->encodePassword($user, $password));

        $em->persist($user);
        $em->flush();

        return $this->json([
            'success' => sprintf('User %s successfully created', $user->getUsername()),
        ]);
    }
}
