Feature: Reporting

  Scenario: Retrieve the reporting in xlsx format for report 05e74904-4a73-4044-90aa-fab8e83a32ca and date 2002-02-14
    Given I add "Accept" header equal to "application/ld+json"
    And I add "Content-Type" header equal to "application/ld+json"
    When I send a POST request to "reporting/generate" with body:
    """
    {
        "report": "/api/reports/05e74904-4a73-4044-90aa-fab8e83a32ca",
        "generationRequests": {"BasicGenerator": {"date": "2002-02-14"}},
        "format": "xlsx"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the JSON node "reportFilename" should exist
    And the JSON node "reportUrl" should exist
