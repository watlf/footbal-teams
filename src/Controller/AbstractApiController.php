<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class AbstractApiController extends AbstractController
{
    /**
     * Fetch list of errors from submitted form
     *
     * @param FormInterface $form
     * @return array
     */
    protected function fetchFormErrors(FormInterface $form)
    {
        $errors = [];

        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                $childErrors = $this->fetchFormErrors($childForm);
                if (!empty($childErrors)) {
                    $errors['errors'][$childForm->getName()] = $childErrors;
                }
            }
        }
        return $errors;
    }

    /**
     * Uses for submit data into form.
     *
     * @param Request $request
     * @param FormInterface $form
     */
    protected function processForm(Request $request, FormInterface $form)
    {
        $data = json_decode($request->getContent(), true);

        $form->submit($data);
    }
}
