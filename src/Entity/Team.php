<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 * @UniqueEntity(fields="name", message="Such name for a football team is already in use")
 */
class Team
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
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type(type="string")
     * @Assert\Length(max=255)
     */
    private $strip;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\League", inversedBy="teams")
     * @ORM\JoinColumn(nullable=true)
     */
    private $league;

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

    public function getStrip(): ?string
    {
        return $this->strip;
    }

    public function setStrip(?string $strip): self
    {
        $this->strip = $strip;

        return $this;
    }

    public function getLeague(): ?League
    {
        return $this->league;
    }

    public function setLeague(?League $league): self
    {
        $this->league = $league;

        return $this;
    }
}
