<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Buzz\Client\FileGetContents;
use Buzz\Message\Request;
use Buzz\Message\Response;

class FeatureContext implements Context {

    /**
     * @var FileGetContents
     */
    protected $browser;

    /**
     * @var Request
     */
    protected $httpResponse;

    /**
     * FeatureContext constructor.
     */
    public function __construct() {
        $this->browser = new FileGetContents();
        $this->httpResponse = new Response();
    }

    protected function getApiResource($resource, $method = 'GET', $payload = null) {
        $request = new Request($method, $resource, 'http://nginx/app_dev.php/api/v1');
        $request->addHeader('Content-type: application/json');
        if($payload) {
            $request->setContent($payload);
        }
        $this->browser->send($request, $this->httpResponse);
    }

    /**
     * @Given /^I fund "([^"]*)" with (\d+) points$/
     */
    public function iFundWithPoints($playerId, $points) {
        $this->getApiResource(sprintf('/fund?playerId=%s&points=%s', $playerId, $points));
    }

    /**
     * @Given /^I announce a tournament with ID "([^"]*)" and set it's deposit to (\d+)$/
     */
    public function iAnnounceATournamentWithIDAndSetItSDepositTo($tournamentId, $deposit) {
        $this->getApiResource(sprintf('/announceTournament?tournamentId=%d&deposit=%d', $tournamentId, $deposit));
    }

    /**
     * @Given /^(P(?:\d+)) joins the tournament "(\d+)"(?: backed by (.*))?$/
     */
    public function playerJoinsTheTournament($playerId, $tournamentId, $backers = '') {
        // /joinTournament?tournamentId=1&playerId=P1&backerId=P2&backerId=P3
        $url = sprintf('/joinTournament?tournamentId=%d&playerId=%s', $tournamentId, $playerId);
        foreach (array_filter(explode(',', $backers)) as $backer) {
            $url .= '&backerId=' . trim($backer);
        }
        $this->getApiResource($url);
    }

    /**
     * @Then /^(P(?:\d+)) should have (\d+) points$/
     */
    public function pshouldHavePoints($playerId, $points) {
        $this->getApiResource(sprintf('/balance?playerId=%s', $playerId));
        $content = json_decode($this->httpResponse->getContent(), true);
        if($content['playerId'] != $playerId) {
            throw new Exception(sprintf('wrong playerId - expected %s but got %s', $playerId, $content['playerId']));
        }
        if($content['balance'] != $points) {
            throw new Exception(sprintf('wrong balance - expected %s but got %s', $points, $content['balance']));
        }
    }

    /**
     * @Then /^I announce the tournament result$/
     */
    public function iAnnounceTheTournamentResult(PyStringNode $string) {
        $this->getApiResource('/resultTournament', 'POST', $string->getRaw());
    }

    /**
     * @Given /^I take (\d+) bonus points from "([^"]*)"$/
     */
    public function iTakeBonusPointsFrom($amount, $playerId) {
        $this->getApiResource(sprintf('/take?playerId=%s&points=%d', $playerId, $amount));
    }

    /**
     * @BeforeScenario
     */
    public static function bootstrapSymfony() {
        exec('php bin/console doctrine:database:drop --force');
        exec('php bin/console doctrine:database:create');
        exec('php bin/console doctrine:schema:update --force');
        exec('php bin/console doctrine:fixtures:load --no-interaction');
    }

}