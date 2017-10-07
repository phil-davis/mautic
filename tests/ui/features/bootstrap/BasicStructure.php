<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\TableNode;
use TestHelpers\SetupHelper;

require_once 'bootstrap.php';

/**
 * Features context.
 */
trait BasicStructure
{
    private $adminUsername;
    private $adminPassword;
    private $salesUsername;
    private $salesPassword;
    private $regularUserPassword;
    private $regularUserName;
    private $regularUserNames = [];
    /**
     * list of users that were created during test runs
     * key is the username value is an array of user attributes.
     *
     * @var array
     */
    private $createdUsers = [];
    private $mauticPath   = null;

    /**
     * @Given I am logged in as admin
     */
    public function iAmLoggedInAsAdmin()
    {
        $this->iAmLoggedInAs($this->adminUsername, $this->adminPassword);
    }

    /**
     * @Given I am logged in as sales
     */
    public function iAmLoggedInAsSales()
    {
        $this->iAmLoggedInAs($this->salesUsername, $this->salesPassword);
    }

    /**
     * @Given I am logged in as a regular user
     */
    public function iAmLoggedInAsARegularUser()
    {
        $this->iAmLoggedInAs($this->regularUserName, $this->regularUserPassword);
    }

    public function iAmLoggedInAs($username, $password)
    {
        $this->loginPage->open();
        $this->filesPage = $this->loginPage->loginAs($username, $password);
        $this->filesPage->waitTillPageIsLoaded($this->getSession());
    }

    /**
     * @Given a regular user exists
     */
    public function aRegularUserExists()
    {
        $this->createUser($this->regularUserName, $this->regularUserPassword);
    }

    /**
     * @Given regular users exist
     */
    public function regularUsersExist()
    {
        foreach ($this->regularUserNames as $user) {
            $this->createUser($user, $this->regularUserPassword);
        }
    }

    /**
     * @Given these users exist:
     * expects a table of users with the heading "|username|password|displayname|email|"
     * displayname & email are optional
     */
    public function theseUsersExist(TableNode $table)
    {
        foreach ($table as $row) {
            if (isset($row['displayname'])) {
                $displayName = $row['displayname'];
            } else {
                $displayName = null;
            }
            if (isset($row['email'])) {
                $email = $row['email'];
            } else {
                $email = null;
            }
            $this->createUser(
                $row ['username'], $row ['password'], $displayName, $email
            );
        }
    }

    /**
     * creates a single user
     * TODO: make something like this work with Mautic.
     *
     * @param string $user
     * @param string $password
     * @param string $displayName
     * @param string $email
     *
     * @throws Exception
     */
    private function createUser(
        $user,
        $password,
        $displayName = null,
        $email = null
    ) {
        $user   = trim($user);
        $result = SetupHelper::createUser(
            $this->mauticPath, $user, $password, $displayName, $email
        );
        if ($result['code'] != 0) {
            throw new Exception('could not create user. '.$result['stdOut'].' '.$result['stdErr']);
        }
        $this->createdUsers [$user] = [
            'password'    => $password,
            'displayname' => $displayName,
            'email'       => $email,
        ];
    }

    /**
     * @BeforeScenario
     */
    public function setUpScenarioGetRegularUsers(BeforeScenarioScope $scope)
    {
        $suiteParameters           = $scope->getEnvironment()->getSuite()->getSettings() ['context'] ['parameters'];
        $this->adminUsername       = (string) $suiteParameters['adminUsername'];
        $this->adminPassword       = (string) $suiteParameters['adminPassword'];
        $this->salesUsername       = (string) $suiteParameters['salesUsername'];
        $this->salesPassword       = (string) $suiteParameters['salesPassword'];
        $this->regularUserNames    = explode(',', $suiteParameters['regularUserNames']);
        $this->regularUserName     = (string) $suiteParameters['regularUserName'];
        $this->regularUserPassword = (string) $suiteParameters['regularUserPassword'];
        $this->mauticPath          = rtrim($suiteParameters['mauticPath'], '/').'/';
    }

    /**
     * @AfterScenario @fixtures
     */
    public function resetTestFixtures()
    {
        SetupHelper::loadTestFixtures($this->mauticPath);
    }

    /**
     * @AfterScenario
     *
     * @throws Exception
     */
    public function tearDownScenarioDeleteCreatedUsers()
    {
        foreach ($this->getCreatedUserNames() as $user) {
            $result = SetupHelper::deleteUser($this->mauticPath, $user);
            if ($result['code'] != 0) {
                throw new Exception('could not delete user. '.$result['stdOut'].' '.$result['stdErr']);
            }
        }
    }

    public function getRegularUserPassword()
    {
        return $this->regularUserPassword;
    }

    public function getRegularUserName()
    {
        return $this->regularUserName;
    }

    public function getRegularUserNames()
    {
        return $this->regularUserNames;
    }

    public function getCreatedUserNames()
    {
        return array_keys($this->createdUsers);
    }

    /**
     * @param string $username
     *
     * @return string password
     */
    public function getUserPassword($username)
    {
        if ($username === $this->adminUsername) {
            $password = $this->adminPassword;
        } elseif ($username === $this->salesUsername) {
            $password = $this->salesPassword;
        } else {
            if (!array_key_exists($username, $this->createdUsers)) {
                throw new Exception("user '$username' was not created by this test run");
            }
            $password = $this->createdUsers[$username]['password'];
        }
        //make sure the function always returns a string
        return (string) $password;
    }

    /**
     * substitutes codes like %base_url% with the value
     * if the given values does not have anything to be substituted its returned unmodified.
     *
     * @param string $value
     *
     * @return string
     */
    public function substituteInLineCodes($value)
    {
        $substitutions = [
            [
                'code'     => '%base_url%',
                'function' => [
                    $this,
                    'getMinkParameter',
                ],
                'parameter' => [
                    'base_url',
                ],
            ],
            [
                'code'     => '%regularuser%',
                'function' => [
                    $this,
                    'getRegularUserName',
                ],
                'parameter' => [],
            ],
        ];
        foreach ($substitutions as $substitution) {
            $value = str_replace(
                $substitution['code'],
                call_user_func_array($substitution['function'], $substitution['parameter']),
                $value
            );
        }

        return $value;
    }
}
