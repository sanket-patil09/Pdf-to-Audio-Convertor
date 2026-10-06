# PDF to Audio Converter

A PHP web application that converts PDF documents into audio, so you can listen to your reading material instead of reading it. Users can register, log in, and use the converter from a clean, video-background landing page.

## Features

- Convert PDF files to audio
- User registration and login
- Forgot password flow
- Logout and session handling
- Contact Us form
- Newsletter subscription
- Responsive front end with a background video

## Tech Stack

- **Backend:** PHP
- **Database:** MySQL (configured in `db_config.php`)
- **Frontend:** HTML, CSS, JavaScript
- **Local server:** XAMPP / WAMP / LAMP (any PHP + MySQL stack)

## Project Structure

```
Pdf-to-Audio-Convertor/
├── .vscode/               # Editor settings
├── Converter/             # PDF-to-audio conversion logic
├── assets/vendor/         # Third-party front-end libraries
├── css/                   # Stylesheets
├── js/                    # JavaScript files
├── bg-video.mp4           # Landing page background video
├── index.php              # Home page
├── register.php           # User registration
├── login.php              # User login
├── logout.php             # User logout
├── forgot_password.php    # Password recovery
├── contactUs.php          # Contact form handler
├── newsLetter.php         # Newsletter subscription handler
├── successfullySent.html  # Confirmation page after sending a message
└── db_config.php          # Database connection settings
```

## Getting Started

### Prerequisites

- PHP 7.4 or higher
- MySQL or MariaDB
- A local web server such as XAMPP, WAMP, or MAMP

### Installation

1. **Clone the repository**

   ```bash
   git clone https://github.com/sanket-patil09/Pdf-to-Audio-Convertor.git
   ```

2. **Move the project into your server's web root**

   - XAMPP: `htdocs/`
   - WAMP: `www/`

3. **Create the database**

   Open phpMyAdmin (or the MySQL CLI) and create a database for the project, then import the SQL file or create the users table your app expects.

4. **Configure the database connection**

   Edit `db_config.php` with your own credentials:

   ```php
   $host     = "localhost";
   $username = "root";
   $password = "";
   $database = "your_database_name";
   ```

5. **Start Apache and MySQL**, then open the app in your browser:

   ```
   http://localhost/Pdf-to-Audio-Convertor/
   ```

## Usage

1. Register a new account, or log in if you already have one.
2. Upload a PDF file on the converter page.
3. Convert it and listen to or download the generated audio.

## Notes

- Never commit real database passwords. Keep production credentials out of `db_config.php` in version control.
- Large PDFs may take longer to convert.

## Contributing

Contributions are welcome.

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/your-feature`
3. Commit your changes: `git commit -m "Add your feature"`
4. Push to the branch: `git push origin feature/your-feature`
5. Open a pull request

## Author

**Sanket Patil**
GitHub: [@sanket-patil09](https://github.com/sanket-patil09)

## License

No license has been specified yet. Add a `LICENSE` file (for example MIT) to define how others may use this project.
