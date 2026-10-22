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
 * Setup helpers for the Lumination AI provider.
 *
 * @package    aiprovider_lumination
 * @copyright  2026 Lumination AI <https://lumination.ai>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace aiprovider_lumination;

/**
 * Setup helpers for the Lumination AI provider.
 *
 * @package    aiprovider_lumination
 * @copyright  2026 Lumination AI <https://lumination.ai>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class setup {
    /**
     * Create an enabled Lumination provider instance from the Course Generator's saved key.
     *
     * Does nothing if the Course Generator has no key or a Lumination instance already exists.
     *
     * @return provider|null The new instance, or null if none was created.
     */
    public static function import_course_generator_key(): ?provider {
        $apikey = api_client::clean_key((string) get_config('local_lumination', 'apikey'));
        if ($apikey === '') {
            return null;
        }
        $manager = \core\di::get(\core_ai\manager::class);
        if ($manager->get_provider_instances(['provider' => provider::class])) {
            return null;
        }
        $baseurl = trim((string) get_config('local_lumination', 'baseurl'));
        return $manager->create_provider_instance(
            classname: provider::class,
            name: get_string('defaultinstancename', 'aiprovider_lumination'),
            enabled: true,
            config: [
                'apikey' => $apikey,
                'baseurl' => $baseurl !== '' ? $baseurl : api_client::DEFAULT_BASE_URL,
            ],
        );
    }
}
