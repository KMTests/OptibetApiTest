<?php

namespace ApiBundle\Entity;

use ApiBundle\Entity\Traits\IdTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PlayerTournamentJoint
 * @package ApiBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="player_tournament_joint")
 */
class PlayerTournamentJoint {

    use IdTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Tournament", inversedBy="players")
     * @ORM\JoinColumn(name="tournament_id", referencedColumnName="id")
     */
    protected $tournament;

    /**
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="tournaments")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     */
    protected $player;

    /**
     * @ORM\Column(type="float", name="bonus_points_frozen", scale=2)
     */
    protected $amountFrozen = 0;

    /**
     * @ORM\OneToMany(targetEntity="TournamentBackers", mappedBy="tournament")
     */
    protected $backers;

    /**
     * PlayerTournamentJoint constructor.
     */
    public function __construct() {
        $this->backers = new ArrayCollection();
    }

    /**
     * Set amountFrozen
     *
     * @param float $amountFrozen
     *
     * @return PlayerTournamentJoint
     */
    public function setAmountFrozen($amountFrozen)
    {
        $this->amountFrozen = $amountFrozen;

        return $this;
    }

    /**
     * Get amountFrozen
     *
     * @return float
     */
    public function getAmountFrozen()
    {
        return $this->amountFrozen;
    }

    /**
     * Set tournament
     *
     * @param \ApiBundle\Entity\Tournament $tournament
     *
     * @return PlayerTournamentJoint
     */
    public function setTournament(\ApiBundle\Entity\Tournament $tournament = null)
    {
        $this->tournament = $tournament;

        return $this;
    }

    /**
     * Get tournament
     *
     * @return \ApiBundle\Entity\Tournament
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * Set player
     *
     * @param \ApiBundle\Entity\Player $player
     *
     * @return PlayerTournamentJoint
     */
    public function setPlayer(\ApiBundle\Entity\Player $player = null)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \ApiBundle\Entity\Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Add backer
     *
     * @param \ApiBundle\Entity\TournamentBackers $backer
     *
     * @return PlayerTournamentJoint
     */
    public function addBacker(\ApiBundle\Entity\TournamentBackers $backer)
    {
        $this->backers[] = $backer;

        return $this;
    }

    /**
     * Remove backer
     *
     * @param \ApiBundle\Entity\TournamentBackers $backer
     */
    public function removeBacker(\ApiBundle\Entity\TournamentBackers $backer)
    {
        $this->backers->removeElement($backer);
    }

    /**
     * Get backers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBackers()
    {
        return $this->backers;
    }
}
