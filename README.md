# Lumination AI Provider for Moodle

Connects Moodle's AI features to the AI Tutor API by Lumination AI. It is also the hub of the Lumination AI plugins for Moodle: the Lumination AI Course Generator and other add-ons use its API key.

## What it does

- Runs Moodle's built-in AI actions on your AI Tutor credits: generate text (for example in the editor), summarise text and explain text (course assistance).
- Holds the AI Tutor API key for all Lumination AI plugins on the site.
- Test connection checks the key and base URL without spending credits, and shows the start, end and length of the key in use so you can compare it with your dashboard.
- English and Spanish interface.

## API key and pricing

1. Register at https://ai-tutor.ai and create a key at https://ai-tutor.ai/dashboard/api. Keys start with `sk-tutor-`.
2. Go to **Site administration > AI > AI providers**, create a **Lumination AI Provider** instance, paste the key and enable it.
3. Click **Test the API key and base URL** on the instance form.
4. Switch on the AI placements you want under **Site administration > AI > AI placements** (text editor, course assistance). Moodle installs them switched off, and users accept Moodle's AI usage policy the first time they use them.

New accounts get $20 of free credits. You are only charged for completed requests. Prices are at https://ai-tutor.ai/api/documentation.

If the Lumination AI Course Generator already has a key when you install this plugin, an enabled instance is created from it automatically.

## Requirements

- Moodle 5.0 or later
- An AI Tutor API key

## Building an add-on

Add-ons depend on this plugin in `version.php`:

```php
$plugin->dependencies = ['aiprovider_lumination' => 2026102200]; // 0.1.0 or later.
```

Public API for add-ons (public methods stay backwards compatible across 0.x releases):

- `\aiprovider_lumination\api_client::for_site()`: a client for the site's first enabled Lumination instance, or null. Then `post()`, `get()`, `put()`, `run($path, $data)` (submit an async job and wait), `check_connection()`.
- `\aiprovider_lumination\api_exception`: thrown on any API failure. `is_fatal()` is true when the key is rejected or out of credits; `$httpcode` and `$requestid` identify the call; `getMessage()` is ready to show to an administrator.
- `\aiprovider_lumination\provider::get_site_instance()`: the instance itself.

## License

GNU GPL v3 or later, https://www.gnu.org/copyleft/gpl.html

## Support

Write to hello@ai-tutor.ai.
