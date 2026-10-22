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
 * Lumination AI provider for Moodle's AI subsystem.
 *
 * @package    aiprovider_lumination
 * @copyright  2026 Lumination AI <https://lumination.ai>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace aiprovider_lumination;

/**
 * Lumination AI provider for Moodle's AI subsystem.
 *
 * Runs Moodle's AI actions (generate, summarise and explain text) on the AI Tutor API,
 * and is the hub of the Lumination AI plugins: add-ons use the key of the site's
 * Lumination provider instance through api_client::for_site().
 *
 * @package    aiprovider_lumination
 * @copyright  2026 Lumination AI <https://lumination.ai>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider extends \core_ai\provider {
    /**
     * The actions this provider supports.
     *
     * @return array Action class names.
     */
    public static function get_action_list(): array {
        return [
            \core_ai\aiactions\generate_text::class,
            \core_ai\aiactions\summarise_text::class,
            \core_ai\aiactions\explain_text::class,
        ];
    }

    /**
     * Whether this instance has an API key.
     *
     * @return bool True if configured.
     */
    public function is_provider_configured(): bool {
        return !empty($this->config['apikey']);
    }

    /**
     * The site's Lumination provider instance: the first enabled one that has a key.
     *
     * @return self|null The instance, or null if none is enabled and configured.
     */
    public static function get_site_instance(): ?self {
        $manager = \core\di::get(\core_ai\manager::class);
        $instances = $manager->get_provider_instances(['provider' => self::class, 'enabled' => 1]);
        ksort($instances);
        foreach ($instances as $instance) {
            if ($instance->is_provider_configured()) {
                return $instance;
            }
        }
        return null;
    }

    /**
     * An API client for this instance.
     *
     * @return api_client The client.
     */
    public function get_client(): api_client {
        return new api_client((string) ($this->config['apikey'] ?? ''), (string) ($this->config['baseurl'] ?? ''));
    }
}
