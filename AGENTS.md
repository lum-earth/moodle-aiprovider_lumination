# Lumination AI Provider for Moodle (aiprovider_lumination)

Rules for coding agents in this repository. Keep this file short and true; update a fact in the same change that makes it untrue.

## What this is

A Moodle 5.0+ AI provider plugin and the hub of the Lumination AI plugins for Moodle. It runs Moodle's AI actions (generate, summarise and explain text) on the AI Tutor API by Lumination AI, holds the API key per provider instance, and gives add-ons a shared client (`api_client::for_site()`, `api_exception`). Add-ons, such as `lum-earth/moodle-local_lumination` (the Course Generator), depend on it.

- Code: `classes/` (provider, one `process_<action>.php` per action, API client, setup), `db/` (hooks, install), `lang/en` and `lang/es`, `tests/`.
- Reference: core `public/ai/provider/openai` in Moodle 5.2 shows the provider API this plugin follows.
- The API is async: POST a job, poll `GET /requests/{id}`. There is no plain text-generation endpoint yet; actions use `/tutor` with a result-only instruction.

## Checks

CI (`.github/workflows/ci.yml`, moodle-plugin-ci) must pass on every supported branch: lint, code checker and PHPDoc with zero warnings, validate, PHPUnit. Local dev: `docker-compose.yml` in the parent workspace runs Moodle 5.2 on port 8081 with this folder mounted at `public/ai/provider/lumination`; upgrade with `php /var/www/html/admin/cli/upgrade.php --non-interactive`.

## Moodle coding rules that CI enforces

- `defined('MOODLE_INTERNAL') || die();` only in files with side effects (`version.php`, `db/*.php`, files that `require_once`). Never in class files, tests or pages that load `config.php`.
- Multi-line `if` conditions: first expression on the line after `(`, closing `)` on its own line.
- Multi-line calls: one argument per line, closing parenthesis on its own line.
- Test classes are `final`. `else if`, not `elseif`. Inline comments end with `.`, `!` or `?`. Lines up to 132 characters (lang files excepted).
- No empty `catch` blocks; no `debugging()` in code that tests run.
- The `curl` class is not autoloaded: `require_once($CFG->libdir . '/filelib.php')` before using it (cron and plain pages do not load it).
- Lang files are plain `$string[...] = '...';` lines, sorted, no concatenation. Text sent to the API is a code constant, not a lang string.

## Boundaries

- Never push, move or delete a Git tag, and never publish a release; the maintainer does that.
- Ask before calls to the real AI Tutor API (they spend credits) and before any other networked side effect.
- Never commit a key, a password or a personal path. Keys live in provider instance config or a local `.env`.
- Keep the public API for add-ons (`api_client`, `api_exception`, `provider::get_site_instance()`) backwards compatible within 0.x.
- Listing names and descriptions follow the Marketplace guide in the maintainer's workspace (`docs/marketplace-listing-guide.md`).
