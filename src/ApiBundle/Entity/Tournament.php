<?php

namespace ApiBundle\Entity;

use ApiBundle\Entity\Traits\IdTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Tournament
 * @package ApiBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="tournament")
 */
class Tournament {

    use IdTrait;

    /**
     * @ORM\Column(type="integer", name="entry_deposit", nullable=true)
     */
    protected $entryDeposit = null;

    /**
     * @ORM\Column(type="boolean", name="announced")
     */
    protected $announced = false;

    /**
     * @ORM\OneToMany(targetEntity="PlayerTournamentJoint", mappedBy="tournament")
     */
    protected $players;

    /**
     * Tournament constructor.
     */
    public function __construct() {
        $this->players = new ArrayCollection();
    }


    /**
     * Set entryDeposit
     *
     * @param integer $entryDeposit
     *
     * @return Tournament
     */
    public function setEntryDeposit($entryDeposit)
    {
        $this->entryDeposit = $entryDeposit;

        return $this;
    }

    /**
     * Get entryDeposit
     *
     * @return integer
     */
    public function getEntryDeposit()
    {
        return $this->entryDeposit;
    }

    /**
     * Set announced
     *
     * @param boolean $announced
     *
     * @return Tournament
     */
    public function setAnnounced($announced)
    {
        $this->announced = $announced;

        return $this;
    }

    /**
     * Get announced
     *
     * @return boolean
     */
    public function getAnnounced()
    {
        return $this->announced;
    }

    /**
     * Add player
     *
     * @param \ApiBundle\Entity\PlayerTournamentJoint $player
     *
     * @return Tournament
     */
    public function addPlayer(\ApiBundle\Entity\PlayerTournamentJoint $player)
    {
        $this->players[] = $player;

        return $this;
    }

    /**
     * Remove player
     *
     * @param \ApiBundle\Entity\PlayerTournamentJoint $player
     */
    public function removePlayer(\ApiBundle\Entity\PlayerTournamentJoint $player)
    {
        $this->players->removeElement($player);
    }

    /**
     * Get players
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayers()
    {
        return $this->players;
    }
}
