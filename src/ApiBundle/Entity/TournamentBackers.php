<?php

namespace ApiBundle\Entity;

use ApiBundle\Entity\Traits\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TournamentBackers
 * @package ApiBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="tournament_backers")
 */
class TournamentBackers {

    use IdTrait;

    /**
     * @ORM\ManyToOne(targetEntity="PlayerTournamentJoint", inversedBy="backers")
     * @ORM\JoinColumn(name="tournament_id", referencedColumnName="id")
     */
    protected $tournament;

    /**
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="backing")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     */
    protected $backer;

    /**
     * @ORM\Column(type="float", name="amount_backed", scale=2)
     */
    protected $amount;
    

    /**
     * Set amount
     *
     * @param float $amount
     *
     * @return TournamentBackers
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set tournament
     *
     * @param \ApiBundle\Entity\PlayerTournamentJoint $tournament
     *
     * @return TournamentBackers
     */
    public function setTournament(\ApiBundle\Entity\PlayerTournamentJoint $tournament = null)
    {
        $this->tournament = $tournament;

        return $this;
    }

    /**
     * Get tournament
     *
     * @return \ApiBundle\Entity\PlayerTournamentJoint
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * Set backer
     *
     * @param \ApiBundle\Entity\Player $backer
     *
     * @return TournamentBackers
     */
    public function setBacker(\ApiBundle\Entity\Player $backer = null)
    {
        $this->backer = $backer;

        return $this;
    }

    /**
     * Get backer
     *
     * @return \ApiBundle\Entity\Player
     */
    public function getBacker()
    {
        return $this->backer;
    }
}
