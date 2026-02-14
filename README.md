# SantePlus

SantePlus is a modern and user-friendly web application designed to streamline the process of scheduling medical appointments. Built with the Symfony framework, it provides a seamless experience for both patients and healthcare providers. Patients can easily find doctors, view their availability, and book appointments online. The platform supports both online and in-person consultations, making healthcare more accessible.

## Key Features
-   **Medecin (Doctor) Management:** A comprehensive system for managing doctor profiles, including their specialties and schedules.
-   **Patient Management:** Allows patients to create and manage their profiles and view their appointment history.
-   **RendezVous (Appointment) Scheduling:** An intuitive interface for scheduling, viewing, and managing appointments.
-   **Admin Dashboard:** A powerful dashboard for administrators to oversee and manage the entire application.

## Our Services

SantePlus offers two types of consultation services to meet the diverse needs of our patients:
-   **Online Consultation:** Patients can connect with doctors remotely through our secure platform, allowing for convenient access to medical advice from the comfort of their homes.
-   **In-Person Consultation:** For appointments that require a physical examination, patients can book a visit to our medical center.

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

-   **Symfony 6.4:** The core PHP framework for building the application.
-   **Doctrine ORM:** For database management and interaction.
-   **Twig:** The templating engine for rendering dynamic content.
-   **Dompdf:** For generating PDF documents.
-   **Bootstrap:** For frontend styling and responsive design.
-   **JavaScript:** For client-side interactivity.
-   **Composer:** For managing PHP dependencies.
