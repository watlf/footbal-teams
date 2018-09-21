<?php

namespace App\Controller;

use App\Entity\League;
use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\TeamRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractApiController
{
    /**
     * Get a list of football teams in a single league
     *
     * @Route("/api/league/{id}/teams",  methods={"GET"})
     * @param int $id
     * @param TeamRepository $teamRepository
     * @return JsonResponse
     */
    public function getTeamsByLeagueId(int $id, TeamRepository $teamRepository)
    {
        $teams = $teamRepository->findTeamsByLeague($id);

        return $this->json($teams);
    }

    /**
     * Create a football team
     *
     * @Route("/api/league/{id}/add-team",  methods={"POST"})
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function createTeam(int $id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $leagueRepository = $em->getRepository(League::class);

        $league = $leagueRepository->find($id);

        if (empty($league)) {
            return $this->json(['error' => 'Such a league was not found'], 404);
        }

        $teamForm = $this->createForm(TeamType::class);

        $this->processForm($request, $teamForm);

        if ($teamForm->isValid()) {
            /** @var Team $newTeam */
            $newTeam = $teamForm->getData();
            $league->addTeam($newTeam);

            $em->persist($league);
            $em->flush();

            return $this->json([
                'success' => sprintf('The team %s was successfully created', $newTeam->getName()),
            ]);
        } else {
            return $this->json($this->fetchFormErrors($teamForm), 409);
        }
    }

    /**
     * Modify all attributes of a football team
     *
     * @Route("/api/edit-team/{id}",  methods={"PUT", "PATCH"})
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function modifyTeam(int $id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $teamRepository = $em->getRepository(Team::class);

        $team = $teamRepository->find($id);

        if (empty($team)) {
            return $this->json(['error' => 'Such a team was not found'], 404);
        }

        $teamForm = $this->createForm(TeamType::class, $team);

        $this->processForm($request, $teamForm);

        if ($teamForm->isValid()) {
            /** @var Team $newTeam */
            $updatedTeam = $teamForm->getData();

            $em->merge($updatedTeam);
            $em->flush();

            return $this->json([
                'success' => 'The team was successfully updated',
            ]);
        } else {
            return $this->json($this->fetchFormErrors($teamForm), 409);
        }
    }

    /**
     * Delete a football league
     *
     * @Route("/api/league/{id}/delete",  methods={"DELETE"})
     * @param int $id
     * @return JsonResponse
     */
    public function deleteLeague(int $id)
    {
        $em = $this->getDoctrine()->getManager();

        $leagueRepository = $em->getRepository(League::class);

        $league = $leagueRepository->find($id);

        if (empty($league)) {
            return $this->json(['error' => 'Such a league was not found'], 404);
        }

        $em->remove($league);
        $em->flush();

        return $this->json([
            'success' => 'The league was successfully deleted',
        ]);
    }
}
