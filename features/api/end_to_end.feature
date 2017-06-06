Business Need: Create feature "back a friend"

  Scenario: end to end code test example
    Given I fund "P1" with 300 points
    And I fund "P2" with 300 points
    And I fund "P3" with 300 points
    And I fund "P4" with 500 points
    And I fund "P5" with 1000 points
    And I announce a tournament with ID "1" and set it's deposit to 1000
    And P5 joins the tournament "1"
    And P1 joins the tournament "1" backed by P2, P3, P4
    Then P1 should have 50 points
    And P2 should have 50 points
    And P3 should have 50 points
    And P4 should have 250 points
    And P5 should have 0 points
    Then I announce the tournament result
    """
    {
      "tournamentId": "1",
      "winners": [
        {
          "playerId": "P1",
          "prize": 2000
        }
      ]
    }
    """
    Then P1 should have 550 points
    And P2 should have 550 points
    And P3 should have 550 points
    And P4 should have 750 points
    And P5 should have 0 points
