# Laravel Product Management Task (AJAX & JSON Storage)

This is a professional Laravel-based product inventory application. It allows users to add, view, and edit product information without page reloads using AJAX.

## Features
-   **AJAX Form Submission:** Add and update products seamlessly.
-   **JSON Storage:** Data is stored in a structured `products.json` file inside the storage folder.
-   **Calculations:** Automatic calculation of total value for each item and a grand total for all stock.
-   **Responsive Design:** Built with Bootstrap 5 for a clean and mobile-friendly UI.
-   **Sorted Display:** Products are ordered by submission date (newest first).

## Requirements
- PHP 8.x
- Composer
- Laravel 10.x / 11.x

## Setup Instructions
1.  **Clone the repository:**
    ```bash
    git clone <https://github.com/hiclassic/product-test.git>
    cd <product-test>
    ```
2.  **Install dependencies:**
    ```bash
    composer install
    npm install
    ```
3.  **Environment Setup:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
4.  **Create Storage Link:**
    ```bash
    php artisan storage:link
    ```
5.  **Run the application:**
    ```bash
    php artisan serve
    npm run dev
    ```
    Access the app at `http://localhost:8000`

## Implementation Details
-   **Storage:** Instead of a traditional database, this project uses `Storage::disk('local')` to manage a JSON file.
-   **Frontend:** jQuery is used for AJAX requests to maintain state without refreshing.