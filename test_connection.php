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
 * Check that the AI Tutor API accepts the site's Lumination key, without spending credits.
 *
 * @package    aiprovider_lumination
 * @copyright  2026 Lumination AI <https://lumination.ai>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');

require_admin();

$PAGE->set_url(new moodle_url('/ai/provider/lumination/test_connection.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('testconnection', 'aiprovider_lumination'));
$PAGE->set_heading(get_string('testconnection', 'aiprovider_lumination'));

$manageurl = \core\plugininfo\aiprovider::get_manage_url();

echo $OUTPUT->header();

$client = \aiprovider_lumination\api_client::for_site();
if (!$client) {
    echo $OUTPUT->notification(get_string('noinstance', 'aiprovider_lumination'), 'error');
} else {
    echo html_writer::tag('p', get_string('testconnection_baseurl', 'aiprovider_lumination', s($client->base_url())));
    echo html_writer::tag('p', get_string('testconnection_key', 'aiprovider_lumination', s($client->key_hint())));
    if (!$client->has_valid_key_format()) {
        echo $OUTPUT->notification(get_string('testconnection_keyformat', 'aiprovider_lumination'), 'warning');
    } else if (!$client->has_complete_key()) {
        echo $OUTPUT->notification(get_string('testconnection_keyincomplete', 'aiprovider_lumination'), 'warning');
    }
    $result = $client->check_connection();
    echo $OUTPUT->notification(s($result['message']), $result['ok'] ? 'success' : 'error');
}

echo html_writer::link($manageurl, get_string('backtoproviders', 'aiprovider_lumination'), ['class' => 'btn btn-secondary mt-3']);
echo $OUTPUT->footer();
