<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Hook callbacks for the Lumination AI provider.
 *
 * @package    aiprovider_lumination
 * @copyright  2026 Lumination AI <https://lumination.ai>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace aiprovider_lumination;

use core_ai\hook\after_ai_provider_form_hook;

/**
 * Hook callbacks for the Lumination AI provider.
 *
 * @package    aiprovider_lumination
 * @copyright  2026 Lumination AI <https://lumination.ai>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class hook_listener {
    /**
     * Add the API key and base URL fields to the provider instance form.
     *
     * @param after_ai_provider_form_hook $hook The hook.
     * @return void
     */
    public static function set_form_definition_for_aiprovider_lumination(after_ai_provider_form_hook $hook): void {
        if ($hook->plugin !== 'aiprovider_lumination') {
            return;
        }
        $mform = $hook->mform;

        $mform->addElement('passwordunmask', 'apikey', get_string('apikey', 'aiprovider_lumination'), ['size' => 75]);
        $mform->addHelpButton('apikey', 'apikey', 'aiprovider_lumination');
        $mform->addRule('apikey', get_string('required'), 'required', null, 'client');

        $mform->addElement('text', 'baseurl', get_string('baseurl', 'aiprovider_lumination'), ['size' => 50]);
        $mform->setType('baseurl', PARAM_URL);
        $mform->setDefault('baseurl', api_client::DEFAULT_BASE_URL);
        $mform->addHelpButton('baseurl', 'baseurl', 'aiprovider_lumination');

        $mform->addElement(
            'static',
            'testconnection',
            '',
            \html_writer::link(
                new \moodle_url('/ai/provider/lumination/test_connection.php'),
                get_string('testconnection_link', 'aiprovider_lumination')
            )
        );
    }
}
