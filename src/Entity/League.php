<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LeagueRepository")
 * @UniqueEntity(fields="name", message="League name is already in use")
 */
class League
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @Assert\Length(min=2, max=50)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Team", mappedBy="league", orphanRemoval=true, cascade={"persist"})
     */
    private $teams;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Team[]
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * @param Team $team
     */
    public function addTeam(Team $team)
    {
        if ($this->teams->contains($team)) {
            return;
        }

        $this->teams[] = $team;

        $team->setLeague($this);
    }

    /**
     * @param Team $team
     */
    public function removeTeam(Team $team)
    {
        $this->teams->removeElement($team);
        $team->setLeague(null);
    }
}
