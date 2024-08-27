# Ibex Wallet
[![Open Source Helpers](https://www.codetriage.com/mjawaids/ibex-wallet/badges/users.svg)](https://www.codetriage.com/mjawaids/ibexpenses)

(UNDER ACTIVE DEVELOPMENT. NOT EVEN IN 'BETA')

Manage your personal finances, budgets and track your expenses with ease. Get AI based suggestions to spend mindfully and save for your better future. Get regular updates on your spendings and forecast your expenses for coming months and years.


## Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and npm
- MySQL or any other supported database

## Setup Instructions

Follow these steps to set up the project locally:

1. **Clone the repository:**

    ```bash
    git clone https://github.com/Ibexoft/ibex-wallet.git
    cd ibex-wallet
    ```

2. **Install PHP dependencies using Composer:**

    ```bash
    composer install
    ```

3. **Set up your environment variables:**

    Copy the example environment file and create a new `.env` file:

    ```bash
    cp .env.example .env
    ```

    Update the `.env` file with your database credentials and other necessary configuration.

4. **Generate an application key:**

    ```bash
    php artisan key:generate
    ```

5. **Run database migrations & seeders:**

    Ensure your database is running and properly configured in the `.env` file, then run:

    ```bash
    php artisan migrate --seed
    ```

6. **Install NPM dependencies:**

    ```bash
    npm install
    ```

7. **Build frontend assets:**

    ```bash
    npm run build
    ```

8. **Start the development server:**

    ```bash
    php artisan serve
    ```

    The application will be available at `http://localhost:8000`.

