<?php

namespace ApiBundle\Managers;

use ApiBundle\Entity\Player;
use ApiBundle\Entity\PlayerTournamentJoint;
use ApiBundle\Entity\Tournament;
use ApiBundle\Entity\TournamentBackers;
use ApiBundle\Exceptions\UnprocessableEntityException;
use Doctrine\ORM\EntityManager;

/**
 * Class TournamentManager
 * @package ApiBundle\Managers
 */
class TournamentManager {

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * TournamentManager constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Tournament $tournament
     * @param string $playerId
     * @param array $backers
     */
    public function joinPlayer(Tournament $tournament, $playerId, array $backers = []) {
        $amount = round($tournament->getEntryDeposit() / (count($backers) + 1), 2);
        $amountCounted = 0;
        $player = $this->getPlayerFromId($playerId);
        $tournamentJoin = new PlayerTournamentJoint();
        $tournamentJoin->setPlayer($player);
        $tournamentJoin->setTournament($tournament);
        $this->entityManager->persist($tournamentJoin);
        foreach ($backers as $backerId) {
            $backer = $this->getPlayerFromId($backerId);
            $backer->takeBonusPoints($amount);
            $amountCounted += $amount;
            $tournamentBacker = new TournamentBackers();
            $this->entityManager->persist($tournamentBacker);
            $tournamentBacker->setBacker($backer);
            $tournamentBacker->setAmount($amount);
            $tournamentBacker->setTournament($tournamentJoin);
            $tournamentJoin->addBacker($tournamentBacker);
        }
        $player->takeBonusPoints($tournament->getEntryDeposit() - $amountCounted);
        $tournamentJoin->setAmountFrozen($tournament->getEntryDeposit() - $amountCounted);
    }

    /**
     * @param Tournament $tournament
     * @param array $winners
     * @throws UnprocessableEntityException
     */
    public function announceResults(Tournament $tournament, array $winners) {
        if(!$tournament->getAnnounced()) {
            throw new UnprocessableEntityException('tournament.not_announced', [
                'tournament_id' => $tournament->getId()
            ]);
        }
        $tournament->setAnnounced(false);
        foreach ($winners as $winner) {
            $this->processTournamentWinner($tournament, $winner['playerId'], $winner['prize']);
        }
    }

    /**
     * @param Tournament $tournament
     * @param string $winnerId
     * @param string $prize
     */
    private function processTournamentWinner(Tournament $tournament, $winnerId, $prize) {
        $players = $tournament->getPlayers();
        $amountPaidOut = 0;
        /** @var PlayerTournamentJoint $tournamentPlayer */
        foreach ($players as $tournamentPlayer) {
            $tournamentPlayer->setAmountFrozen(0);
            $player = $tournamentPlayer->getPlayer();
            if($player->getId() == filter_var($winnerId, FILTER_SANITIZE_NUMBER_INT)) {
                $backers = $tournamentPlayer->getBackers();
                $amountPerPlayer = round($prize / (count($backers) + 1), 2);
                /** @var TournamentBackers $tournamentBacker */
                foreach ($backers as $tournamentBacker) {
                    $tournamentBacker->setAmount(0);
                    $tournamentBacker->getBacker()->addBonusPoints($amountPerPlayer);
                    $amountPaidOut += $amountPerPlayer;
                }
                $player->addBonusPoints($prize - $amountPaidOut);
            }
        }
    }


    /**
     * @param string $playerId
     * @return Player
     * @throws UnprocessableEntityException
     */
    private function getPlayerFromId($playerId) {
        $playerId = filter_var($playerId, FILTER_SANITIZE_NUMBER_INT);
        $player = $this->entityManager->getRepository(Player::class)->find($playerId);
        if(!$player instanceof Player) {
            throw new UnprocessableEntityException('player.not_found', ['player_id' => $playerId]);
        }
        return $player;
    }

}