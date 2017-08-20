<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Page;

use Psr\Log\InvalidArgumentException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException;

class NavSidebarPage extends MauticPage
{
    /**
     * @var string $path
     */
    protected $path = '/s/login';

    protected $navSidebarIds = [
        'dashboard' => 'mautic_dashboard_index',
        'calendar' => 'mautic_calendar_index',
        'contacts' => 'mautic_contact_index',
        'companies' => 'mautic_company_index',
        'segments' => 'mautic_segment_index',
        'components' => 'mautic_components_root',
        'campaigns' => 'mautic_campaign_index',
        'channels' => 'mautic_channels_root',
        'points' => 'mautic_points_root',
        'stages' => 'mautic_stage_index',
        'reports' => 'mautic_report_index',
    ];

    protected $navSidebarSubIds = [
        'components' => [
            'assets' => 'mautic_asset_index',
            'forms' => 'mautic_form_index',
            'landing pages' => 'mautic_page_index',
            'dynamic content' => 'mautic_dynamicContent_index',
        ],
        'channels' => [
            'marketing messages' => 'mautic_message_index',
            'emails' => 'mautic_email_index',
            'focus items' => 'mautic_focus_index',
            'social monitoring' => 'mautic_social_index',
        ],
        'points' => [
            'manage actions' => 'mautic_point_index',
            'manage triggers' => 'mautic_pointtrigger_index',
        ],
    ];

    protected $navSidebarPages = [
        'dashboard' => 'DashboardPage',
        'calendar' => 'CalendarPage',
        'contacts' => 'ContactsPage',
        'companies' => 'CompaniesPage',
        'segments' => 'SegmentsPage',
        'assets' => 'AssetsPage',
        'forms' => 'FormsPage',
        'landing pages' => 'LandingPagesPage',
        'dynamic content' => 'DynamicContentPage',
        'campaigns' => 'CampaignsPage',
        'marketing messages' => 'MarketingMessagesPage',
        'emails' => 'EmailsPage',
        'focus items' => 'FocusItemsPage',
        'social monitoring' => 'SocialMonitoringPage',
        'manage actions' => 'PointsPage',
        'manage triggers' => 'PointTriggersPage',
        'stages' => 'StagesPage',
        'reports' => 'ReportsPage',
    ];

    public function selectNavSidebarEntry($mainEntry, $subEntry = null, $clickTheMainEntry = true)
    {
        $mainEntry = strtolower($mainEntry);

        if (!array_key_exists($mainEntry, $this->navSidebarIds)) {
            throw new InvalidArgumentException("no such nav sidebar main entry " . $mainEntry);
        }

        if (!is_null($subEntry)) {
            $subEntry = strtolower($subEntry);

            if (!array_key_exists($subEntry, $this->navSidebarSubIds[$mainEntry])) {
                throw new InvalidArgumentException("no such nav sidebar sub entry " . $subEntry);
            }
        }

        $mainId = $this->navSidebarIds[$mainEntry];
        $navMainSidebarElement = $this->findById($mainId);

        if ($navMainSidebarElement === null) {
            throw new ElementNotFoundException("could not find nav sidebar main element " . $mainId);
        }

        if ($clickTheMainEntry) {
            $navMainSidebarElement->click();
        }

        if (is_null($subEntry)) {
            $page = $this->navSidebarPages[$mainEntry];
        } else {
            $subId = $this->navSidebarSubIds[$mainEntry][$subEntry];
            $navSubSidebarElement = $this->findById($subId);

            if ($navSubSidebarElement === null) {
                throw new ElementNotFoundException("could not find nav sidebar sub element " . $subId);
            }

            $navSubSidebarElement->click();
            $page = $this->navSidebarPages[$subEntry];
        }

        return $this->getPage($page);
    }
}
