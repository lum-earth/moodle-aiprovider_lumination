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
 * English language strings for aiprovider_lumination.
 *
 * @package    aiprovider_lumination
 * @copyright  2026 Lumination AI <https://lumination.ai>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['apikey'] = 'AI Tutor API key';
$string['apikey_help'] = 'Your AI Tutor API key (it starts with sk-tutor-). Register at https://ai-tutor.ai and create a key at https://ai-tutor.ai/dashboard/api. New accounts get $20 of free credits. The Lumination AI Course Generator and other Lumination add-ons use this key too.';
$string['backtoproviders'] = 'Back to AI providers';
$string['baseurl'] = 'API base URL';
$string['baseurl_help'] = 'The AI Tutor API base URL, including /api/v1. Leave the default unless Lumination AI gives you another one.';
$string['defaultinstancename'] = 'Lumination AI';
$string['error_emptyreply'] = 'The AI Tutor API returned an empty answer.';
$string['errorapiconnect'] = 'Could not connect to the AI Tutor API at {$a->host} ({$a->detail}). Check the API base URL in the plugin settings and that this server can reach the internet. Request ID: {$a->requestid}';
$string['errorapicredits'] = 'Your AI Tutor API key has run out of credits (HTTP 402). Buy credits at https://ai-tutor.ai/dashboard/api and try again. Request ID: {$a->requestid}';
$string['errorapihttp'] = 'The AI Tutor API at {$a->host} returned HTTP {$a->code}: {$a->detail}. Request ID: {$a->requestid}';
$string['errorapijob'] = 'The AI Tutor API could not complete the request: {$a->detail}. Request ID: {$a->requestid}';
$string['errorapikey'] = 'The AI Tutor API at {$a->host} rejected the API key (HTTP {$a->code}: {$a->detail}). Open Test connection from the Lumination AI provider settings to see which key Moodle is using and compare it with the key in https://ai-tutor.ai/dashboard/api. Also check that the API base URL is https://ai-tutor.ai/api/v1. Request ID: {$a->requestid}';
$string['keyhint'] = '{$a->start}...{$a->end} ({$a->length} characters)';
$string['noinstance'] = 'No Lumination AI provider is enabled. Create one under Site administration > AI > AI providers, add your API key and enable it.';
$string['pluginname'] = 'Lumination AI Provider';
$string['privacy:metadata:aitutor'] = 'The AI Tutor API by Lumination AI processes the text it receives to answer the request.';
$string['privacy:metadata:aitutor:prompttext'] = 'The text a user entered or selected, with Moodle\'s instruction for the action.';
$string['testconnection'] = 'Test connection';
$string['testconnection_baseurl'] = 'API base URL in use: {$a}';
$string['testconnection_key'] = 'API key in use: {$a}';
$string['testconnection_keyformat'] = 'The API key does not start with sk-tutor-, so it is probably a key from the old Lumination API. Create a new key at https://ai-tutor.ai/dashboard/api.';
$string['testconnection_keyincomplete'] = 'The API key does not look complete. AI Tutor keys are sk-tutor- followed by 48 letters and numbers. If the dashboard shows the key shortened or hidden (with ... or dots), create a new key and copy it in full when it is shown.';
$string['testconnection_link'] = 'Test the API key and base URL';
$string['testconnection_notapi'] = 'The server at {$a->host} answered with HTTP {$a->code}, but it does not look like the AI Tutor API ({$a->detail}). Check the API base URL; it should be https://ai-tutor.ai/api/v1. Request ID: {$a->requestid}';
$string['testconnection_ok'] = 'Connected to {$a->host}. The API key was accepted.';
