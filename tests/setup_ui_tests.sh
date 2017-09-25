#!/bin/bash
#
# @copyright   2014 Mautic Contributors. All rights reserved
# @author      Mautic
#
# @link        http://mautic.org
#
# @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
#
php app/console doctrine:database:create --env=test
php app/console doctrine:schema:create --env=test
php app/console doctrine:migrations:version --add --all --no-interaction --env=test
php app/console doctrine:fixtures:load --no-interaction --env=test

cp tests/ui/tests_ui_local.php app/config/local.php
