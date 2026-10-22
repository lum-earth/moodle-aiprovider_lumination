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
 * Unit tests for the Lumination AI provider and its setup.
 *
 * @package    aiprovider_lumination
 * @copyright  2026 Lumination AI <https://lumination.ai>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @category   test
 */

namespace aiprovider_lumination;

/**
 * Tests for {@see \aiprovider_lumination\provider} and {@see \aiprovider_lumination\setup}.
 *
 * @covers \aiprovider_lumination\provider
 * @covers \aiprovider_lumination\setup
 */
final class provider_test extends \advanced_testcase {
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();
    }

    /**
     * Create a provider instance.
     *
     * @param bool $enabled Whether it is enabled.
     * @param array $config Instance config.
     * @return provider The instance.
     */
    private function create_instance(bool $enabled, array $config): provider {
        $manager = \core\di::get(\core_ai\manager::class);
        return $manager->create_provider_instance(
            classname: provider::class,
            name: 'Test',
            enabled: $enabled,
            config: $config,
        );
    }

    /**
     * Test the supported actions.
     */
    public function test_get_action_list(): void {
        $this->assertSame([
            \core_ai\aiactions\generate_text::class,
            \core_ai\aiactions\summarise_text::class,
            \core_ai\aiactions\explain_text::class,
        ], provider::get_action_list());
    }

    /**
     * Test that the site instance is the first enabled instance with a key.
     */
    public function test_get_site_instance(): void {
        $this->assertNull(provider::get_site_instance());
        $this->assertNull(api_client::for_site());

        $this->create_instance(false, ['apikey' => 'sk-tutor-disabled']);
        $this->create_instance(true, ['apikey' => '']);
        $this->assertNull(provider::get_site_instance());

        $this->create_instance(true, ['apikey' => ' sk-tutor-site ', 'baseurl' => 'https://example.com/api/v1/']);
        $instance = provider::get_site_instance();
        $this->assertNotNull($instance);
        $this->assertTrue($instance->is_provider_configured());

        $client = api_client::for_site();
        $this->assertTrue($client->is_configured());
        $this->assertSame('https://example.com/api/v1', $client->base_url());
        $this->assertStringContainsString('sk-tutor-', $client->key_hint());
    }

    /**
     * Test that the Course Generator's key becomes an enabled instance, once.
     */
    public function test_import_course_generator_key(): void {
        unset_config('apikey', 'local_lumination');
        $this->assertNull(setup::import_course_generator_key());

        set_config('apikey', " sk-tutor-abc\n", 'local_lumination');
        unset_config('baseurl', 'local_lumination');
        $instance = setup::import_course_generator_key();
        $this->assertNotNull($instance);
        $this->assertTrue($instance->enabled);
        $this->assertSame('sk-tutor-abc', $instance->config['apikey']);
        $this->assertSame(api_client::DEFAULT_BASE_URL, $instance->config['baseurl']);

        // A second run does not create another instance.
        $this->assertNull(setup::import_course_generator_key());
        $manager = \core\di::get(\core_ai\manager::class);
        $this->assertCount(1, $manager->get_provider_instances(['provider' => provider::class]));
    }
}
