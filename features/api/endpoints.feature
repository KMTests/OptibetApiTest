Business Need: Test individual endpoints

  Scenario: I can give user bonus points
    Given I fund "P1" with 300 points
    Then P1 should have 300 points
    And I fund "P1" with 123 points
    Then P1 should have 423 points

  Scenario: I can take user bonus points
    Given I fund "P1" with 8000 points
    And I take 4000 bonus points from "P1"
    Then P1 should have 4000 points