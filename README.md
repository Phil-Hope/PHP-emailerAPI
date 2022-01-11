# PHP EMAILER API
#### Backend API to send emails from frontend forms.

This uses two separate API endpoints:
- /contact
- /booking

Accepts a POST request and uses the JSON data to then send a formatted email to the applicable recipient.

In order for this to work, it must be hosted in an environment that has an active emailing service.
Check your PHP.ini to ensure the correct configuration.

Author: Phil Hope
