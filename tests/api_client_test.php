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
 * Unit tests for the API client and its exception.
 *
 * @package    aiprovider_lumination
 * @copyright  2026 Lumination AI <https://lumination.ai>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @category   test
 */

namespace aiprovider_lumination;

/**
 * Tests for {@see \aiprovider_lumination\api_client} and {@see \aiprovider_lumination\api_exception}.
 *
 * @covers \aiprovider_lumination\api_client
 * @covers \aiprovider_lumination\api_exception
 */
final class api_client_test extends \advanced_testcase {
    /**
     * Test that invisible characters and quotes pasted with a key are removed.
     */
    public function test_clean_key(): void {
        $key = 'sk-tutor-' . str_repeat('a1', 24);
        $this->assertSame($key, api_client::clean_key("\u{00A0}" . $key . "\u{200B}\r\n"));
        $this->assertSame($key, api_client::clean_key("\u{FEFF}\"" . $key . "\""));
        $this->assertFalse((new api_client(" \n"))->is_configured());
    }

    /**
     * Test the base URL default, trimming and host.
     */
    public function test_base_url(): void {
        $client = new api_client('sk-tutor-x');
        $this->assertSame(api_client::DEFAULT_BASE_URL, $client->base_url());
        $this->assertSame('ai-tutor.ai', $client->host());

        $client = new api_client('sk-tutor-x', ' https://example.com/api/v1/ ');
        $this->assertSame('https://example.com/api/v1', $client->base_url());
        $this->assertSame('example.com', $client->host());
    }

    /**
     * Test the key format checks and the safe hint.
     */
    public function test_key_checks(): void {
        $key = 'sk-tutor-' . str_repeat('ab12', 12);
        $client = new api_client($key);
        $this->assertTrue($client->has_valid_key_format());
        $this->assertTrue($client->has_complete_key());
        $this->assertStringContainsString('sk-tutor-...ab12', $client->key_hint());
        $this->assertStringNotContainsString($key, $client->key_hint());

        $this->assertFalse((new api_client('sk-tutor-ab12…cd34'))->has_complete_key());
        $this->assertFalse((new api_client('lum_live_abc123'))->has_valid_key_format());
    }

    /**
     * Test that HTTP codes map to the right message and fatal flag.
     */
    public function test_api_exception(): void {
        $this->resetAfterTest();
        $e = new api_exception(401, 'Invalid API key', 'ai-tutor.ai', 'moodle-abc');
        $this->assertSame('errorapikey', $e->errorcode);
        $this->assertTrue($e->is_fatal());
        $this->assertStringContainsString('moodle-abc', $e->getMessage());

        $this->assertSame('errorapicredits', (new api_exception(402, 'x', 'h', 'r'))->errorcode);
        $this->assertSame('errorapihttp', (new api_exception(500, 'x', 'h', 'r'))->errorcode);
        $this->assertSame('errorapijob', (new api_exception(0, 'x', 'h', 'r'))->errorcode);
        $this->assertSame('errorapiconnect', (new api_exception(0, 'x', 'h', 'r', true))->errorcode);
        $this->assertSame('errorapitimeout', (new api_exception(0, 'x', 'h', 'r', true, true))->errorcode);
    }
}
