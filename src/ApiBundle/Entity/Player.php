<?php

namespace ApiBundle\Entity;

use ApiBundle\Entity\PlayerTournamentJoint;
use ApiBundle\Entity\TournamentBackers;
use ApiBundle\Entity\Traits\IdTrait;
use ApiBundle\Exceptions\UnprocessableEntityException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Player
 * @package ApiBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="player")
 */
class Player {

    use IdTrait;

    /**
     * @ORM\Column(type="float", name="bonus_points", scale=2)
     */
    protected $bonusPoints = 0;

    /**
     * @ORM\OneToMany(targetEntity="PlayerTournamentJoint", mappedBy="player")
     */
    protected $tournaments;

    /**
     * @ORM\OneToMany(targetEntity="TournamentBackers", mappedBy="backer")
     */
    protected $backing;

    /**
     * Player constructor.
     */
    public function __construct() {
        $this->tournaments = new ArrayCollection();
        $this->backing = new ArrayCollection();
    }

    /**
     * Set bonusPoints
     * @param float $bonusPoints
     * @return Player
     */
    public function setBonusPoints($bonusPoints) {
        $this->bonusPoints = $bonusPoints;
        return $this;
    }

    /**
     * Get bonusPoints
     * @return float
     */
    public function getBonusPoints() {
        return $this->bonusPoints;
    }

    /**
     * @param PlayerTournamentJoint $tournament
     * @return Player
     */
    public function addTournament(PlayerTournamentJoint $tournament) {
        $this->tournaments[] = $tournament;
        return $this;
    }

    /**
     * @param PlayerTournamentJoint $tournament
     */
    public function removeTournament(PlayerTournamentJoint $tournament) {
        $this->tournaments->removeElement($tournament);
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTournaments() {
        return $this->tournaments;
    }

    /**
     * @param TournamentBackers $backing
     * @return Player
     */
    public function addBacking(TournamentBackers $backing) {
        $this->backing[] = $backing;
        return $this;
    }

    /**
     * @param TournamentBackers $backing
     */
    public function removeBacking(TournamentBackers $backing) {
        $this->backing->removeElement($backing);
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBacking() {
        return $this->backing;
    }

    /**
     * @param float $amount
     * @return $this
     * @throws UnprocessableEntityException
     */
    public function takeBonusPoints($amount) {
        if($this->bonusPoints - $amount < 0) {
            throw new UnprocessableEntityException('user.insufficient.bonus_points', [
                'amount_required' => $amount,
                'amount_user_has' => $this->bonusPoints
            ]);
        } else {
            $this->bonusPoints -= $amount;
        }
        return $this;
    }

    /**
     * @param float $amount
     * @return $this
     */
    public function addBonusPoints($amount) {
        $this->bonusPoints += $amount;
        return $this;
    }
}
