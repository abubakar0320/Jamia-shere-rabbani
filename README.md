# Jamia Shere Rabbani Mananwala,  Pakistan Portal

## Local Development Setup

1. Prerequisites:
   - PHP 8.0 or higher
   - Composer
   - XAMPP/WAMP/MAMP

2. Installation:
   ```bash
   # Install dependencies
   composer install

   # Copy environment file
   cp .env.example .env
   ```

3. Configure your environment:
   - Update `.env` with your Supabase credentials
   - Configure your local PHP server

4. Start the server:
   - Using XAMPP: Place the project in htdocs folder
   - Using PHP built-in server: `php -S localhost:8000`

5. Access the site:
   - Open http://localhost:8000 in your browser

## Project Structure

```
├── config/             # Configuration files
├── includes/           # PHP includes
├── public/            # Public assets
├── src/               # Source files
├── supabase/          # Supabase migrations
├── vendor/            # Composer dependencies
├── .env               # Environment variables
├── .htaccess          # Apache configuration
└── composer.json      # Composer configuration
```
