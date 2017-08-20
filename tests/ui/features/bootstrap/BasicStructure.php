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
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Gherkin\Node\TableNode;
use TestHelpers\SetupHelper;

require_once 'bootstrap.php';

/**
 * Features context.
 */
trait BasicStructure
{
    private $adminPassword;
    private $regularUserPassword;
    private $regularUserName;
    private $regularUserNames = array();
    /**
     * list of users that were created during test runs
     * key is the username value is an array of user attributes
     * @var array
     */
    private $createdUsers = array();
    private $mauticPath;

    /**
     * @Given I am logged in as admin
     */
    public function iAmLoggedInAsAdmin()
    {
        $this->loginPage->open();
        $this->filesPage = $this->loginPage->loginAs("mauticadmin", "admin123");
        $this->filesPage->waitTillPageIsLoaded($this->getSession());
    }

    /**
     * @Given I am logged in as a regular user
     */
    public function iAmLoggedInAsARegularUser()
    {
        $this->loginPage->open();
        $this->filesPage = $this->loginPage->loginAs($this->regularUserName, $this->regularUserPassword);
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
     * TODO: make something like this work with Mautic
     * @param string $user
     * @param string $password
     * @param string $displayName
     * @param string $email
     * @throws Exception
     */
    private function createUser(
        $user,
        $password,
        $displayName = null,
        $email = null
    ) {
        $user = trim($user);
        $result = SetupHelper::createUser(
            $this->mauticPath, $user, $password, $displayName, $email
        );
        if ($result["code"] != 0) {
            throw new Exception("could not create user. " . $result["stdOut"] . " " . $result["stdErr"]);
        }
        $this->createdUsers [$user] = [
            "password" => $password,
            "displayname" => $displayName,
            "email" => $email
        ];
    }
    /** @BeforeScenario */
    public function setUpScenarioGetRegularUsers(BeforeScenarioScope $scope)
    {
        $suiteParameters = $scope->getEnvironment()->getSuite()->getSettings() ['context'] ['parameters'];
        $this->adminPassword = (string)$suiteParameters['adminPassword'];
        $this->regularUserNames = explode(",", $suiteParameters['regularUserNames']);
        $this->regularUserName = (string)$suiteParameters['regularUserName'];
        $this->regularUserPassword = (string)$suiteParameters['regularUserPassword'];
        $this->mauticPath = rtrim($suiteParameters['mauticPath'], '/') . '/';
    }

    /** @AfterScenario */
    public function tearDownScenarioDeleteCreatedUsers(AfterScenarioScope $scope)
    {
        foreach ($this->getCreatedUserNames() as $user) {
            $result = SetupHelper::deleteUser($this->mauticPath, $user);
            if ($result["code"] != 0) {
                throw new Exception("could not delete user. " . $result["stdOut"] . " " . $result["stdErr"]);
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
     *
     * @param string $username
     * @return string password
     */
    public function getUserPassword($username)
    {
        if ($username === 'admin') {
            $password = $this->adminPassword;
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
     * if the given values does not have anything to be substituted its returned unmodified
     * @param string $value
     * @return string
     */
    public function substituteInLineCodes($value)
    {
        $substitutions = [
            [
                "code" => "%base_url%",
                "function" => [
                    $this,
                    "getMinkParameter"
                ],
                "parameter" => [
                    "base_url"
                ]
            ],
            [
                "code" => "%regularuser%",
                "function" => [
                    $this,
                    "getRegularUserName"
                ],
                "parameter" => [ ]
            ]
        ];
        foreach ($substitutions as $substitution) {
            $value = str_replace(
                $substitution["code"],
                call_user_func_array($substitution["function"], $substitution["parameter"]),
                $value
            );
        }
        return $value;
    }
}
