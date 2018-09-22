<?php

namespace App\Controller;

use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractApiController
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

        $userForm = $this->createForm(UserType::class);

        $this->processForm($request, $userForm);

        if ($userForm->isValid()) {
            /** @var User $user */
            $user = $userForm->getData();

            $user->setPassword($user->getPassword());
            $em->persist($user);
            $em->flush();

            return $this->json([
                'success' => sprintf('User %s successfully created', $user->getUsername()),
            ]);

        } else {
            return $this->json($this->fetchFormErrors($userForm), 409);
        }
    }
}
