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
 * Generate text action processor.
 *
 * @package    aiprovider_lumination
 * @copyright  2026 Lumination AI <https://lumination.ai>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace aiprovider_lumination;

/**
 * Generate text action processor.
 *
 * The AI Tutor API has no plain text-generation endpoint yet, so this sends Moodle's
 * system instruction and the user's prompt to /tutor (submit and poll) and asks for
 * the result only.
 *
 * @package    aiprovider_lumination
 * @copyright  2026 Lumination AI <https://lumination.ai>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class process_generate_text extends \core_ai\process_base {
    /** @var string Keeps the tutoring persona out of answers shown as content. Sent to the API, so not a lang string. */
    private const RESULT_ONLY = 'Answer with the requested text only. Do not add greetings, questions, offers of further help '
        . 'or comments about yourself.';

    /**
     * Send the prompt to the API and wait for the reply.
     *
     * @return array Response fields for Moodle's AI subsystem, or error details.
     */
    protected function query_ai_api(): array {
        $client = $this->provider->get_client();
        try {
            $job = $client->run('/tutor', ['message' => $this->build_message()]);
        } catch (api_exception $e) {
            $code = $e->httpcode > 0 ? $e->httpcode : 500;
            return \core_ai\error\factory::create($code, $e->getMessage())->get_error_details();
        }

        $reply = $job['result']['reply'] ?? '';
        if (!is_string($reply) || trim($reply) === '') {
            return \core_ai\error\factory::create(500, get_string('error_emptyreply', 'aiprovider_lumination'))
                ->get_error_details();
        }

        return [
            'success' => true,
            'id' => (string) ($job['request_id'] ?? ''),
            'fingerprint' => '',
            'generatedcontent' => trim($reply),
            'finishreason' => 'stop',
            'prompttokens' => (int) ($job['input_tokens'] ?? 0),
            'completiontokens' => (int) ($job['output_tokens'] ?? 0),
            'model' => 'ai-tutor',
        ];
    }

    /**
     * The message sent to /tutor: Moodle's instruction for this action, then the prompt.
     *
     * @return string The message.
     */
    protected function build_message(): string {
        $instruction = $this->action::get_system_instruction();
        $prompt = (string) $this->action->get_configuration('prompttext');
        $parts = [];
        if ($instruction !== '') {
            $parts[] = $instruction;
        }
        $parts[] = self::RESULT_ONLY;
        $parts[] = $prompt;
        return implode("\n\n", $parts);
    }
}
