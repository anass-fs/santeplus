# SantePlus

SantePlus is a web application built with Symfony that helps manage medical appointments. It features user authentication, doctor and patient management, appointment scheduling, and PDF generation for appointments.

## Features

-   **User Authentication:** Secure login and registration for different user roles (e.g., admin, patient).
-   **Medecin (Doctor) Management:** Create, read, update, and delete doctor profiles.
-   **Patient Management:** Create, read, update, and delete patient profiles.
-   **RendezVous (Appointment) Scheduling:** Schedule and manage appointments between patients and doctors.
-   **PDF Generation:** Generate printable PDF documents for appointment details using Dompdf.
-   **Admin Dashboard:** A dedicated interface for administrators to manage the application's data.

## Installation

Follow these steps to set up the SantePlus project on your local machine.

### Prerequisites

-   PHP 8.1 or higher
-   Composer
-   A database server (e.g., MySQL, PostgreSQL)

### Steps

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/your-username/santeplus.git
    cd santeplus
    ```

2.  **Install Composer dependencies:**

    ```bash
    composer install
    ```

3.  **Configure your environment variables:**
    Copy the `.env` file and create a `.env.local` file.
    ```bash
    cp .env .env.local
    ```
    Edit `.env.local` and update the `DATABASE_URL` with your database credentials.

    ```dotenv
    # .env.local
    DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7&charset=utf8mb4"
    ```

4.  **Create the database and run migrations:**

    ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```

5.  **Load initial data (optional):**
    If you have data fixtures, you can load them using:

    ```bash
    php bin/console doctrine:fixtures:load
    ```

## Usage

1.  **Start the Symfony local server:**

    ```bash
    symfony server:start
    ```

    Alternatively, you can use PHP's built-in web server:

    ```bash
    php -S 127.0.0.1:8000 -t public
    ```

2.  **Access the application:**
    Open your web browser and go to `http://127.0.0.1:8000`.

## Technologies Used

-   **Symfony 6.4:** PHP Framework
-   **Doctrine ORM:** For database interaction
-   **Twig:** Templating engine
-   **Dompdf:** For PDF generation
-   **Bootstrap (implied by assets/css/style.css, admin.css):** Frontend styling
-   **JavaScript (implied by assets/js/script.js):** Frontend interactivity
-   **Composer:** Dependency Management