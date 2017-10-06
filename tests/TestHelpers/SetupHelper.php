<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace TestHelpers;

/**
 * Helper to setup UI / API tests.
 *
 * TODO: code template from ownCloud. Find out a good way to create/delete users in Mautic
 */
class SetupHelper
{
    /**
     * creates a user.
     *
     * @param string $mauticPath
     * @param string $userName
     * @param string $password
     * @param string $displayName
     * @param string $email
     *
     * @return string[] associated array with "code", "stdOut", "stdErr"
     */
    public static function createUser(
        $mauticPath,
        $userName,
        $password,
        $displayName = null,
        $email = null
    ) {
        $mauticCommand = ['user:add', '--password-from-env'];
        if ($displayName !== null) {
            $mauticCommand = array_merge($mauticCommand, ['--display-name', $displayName]);
        }
        if ($email !== null) {
            $mauticCommand = array_merge($mauticCommand, ['--email', $email]);
        }
        putenv('OC_PASS='.$password);

        return self::runMauticCommand(array_merge($mauticCommand, [$userName]), $mauticPath);
    }

    /**
     * deletes a user.
     *
     * @param string $mauticPath
     * @param string $userName
     *
     * @return string[] associated array with "code", "stdOut", "stdErr"
     */
    public static function deleteUser($mauticPath, $userName)
    {
        return self::runMauticCommand(['user:delete', $userName], $mauticPath);
    }

    /**
     * @param string $ocPath
     * @param string $userName
     * @param string $app
     * @param string $key
     * @param string $value
     *
     * @return string[]
     */
    public static function changeUserSetting(
        $mauticPath, $userName, $app, $key, $value
    ) {
        return self::runMauticCommand(
            ['user:setting', '--value '.$value, $userName, $app, $key], $mauticPath
        );
    }

    /**
     * (Re)load the test fixtures (test database data).
     *
     * @param string $mauticPath
     *
     * @return string[] associated array with "code", "stdOut", "stdErr"
     */
    public static function loadTestFixtures($mauticPath)
    {
        exec('mysql -u travis -e "set global foreign_key_checks=0;"');
        $output = self::runMauticCommand(['doctrine:fixtures:load', '--env=test', '--no-interaction'], $mauticPath);
        exec('mysql -u travis -e "set global foreign_key_checks=1;"');

        return $output;
    }

    /**
     * invokes a Mautic console command.
     *
     * @param array  $args       anything behind "app/console".
     *                           For example: "user:add"
     * @param string $mauticPath
     * @param string $escaping
     *
     * @return string[] associated array with "code", "stdOut", "stdErr"
     */
    public static function runMauticCommand($args, $mauticPath, $escaping = true)
    {
        if ($escaping === true) {
            $args = array_map(
                function ($arg) {
                    return escapeshellarg($arg);
                }, $args
            );
        }
        $args[] = '--no-ansi';
        $args   = implode(' ', $args);

        $descriptor = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];
        $process = proc_open(
            'php app/console '.$args, $descriptor, $pipes, $mauticPath
        );
        $lastStdOut = stream_get_contents($pipes[1]);
        $lastStdErr = stream_get_contents($pipes[2]);
        $lastCode   = proc_close($process);

        return [
            'code'   => $lastCode,
            'stdOut' => $lastStdOut,
            'stdErr' => $lastStdErr,
        ];
    }
}
