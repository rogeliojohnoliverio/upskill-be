## Personal Info QR code

### The goal of this project is to enhance the developers skills in deployment and typescript.

### This project takes user's info and generates a one time QR code

in which they can view their personal info after they scan code.

### BE

This project was created by Laravel. To run this project locally,

    1.Make sure you have installed php you can download php here https://www.php.net/downloads.php.Verify the installation: Run php -v in your terminal.
    2.Run composer install
    3.Copy .env.example to .env `cp .env.example .env`
    3.Run php artisan key:generate
    4.Run php artisan serve
    5.Open http://127.0.0.1:8000 to view it in the browser.

### Cloudinary (S3 alternative and a custom filesystem)

Cloudinary makes it easy for us to store, transform, optimize, and deliver all your media assets with easy-to-use APIs, widgets, or user interface just as how we S3 is used. In order to setup Cloudinary,

1. Create a free account at https://cloudinary.com/
2. Get the Product Environment Credentials (Cloud Name, API Key, API Secret)
3. On your .env file, add the following:
    ```
    CLOUDINARY_API_KEY=
    CLOUDINARY_API_SECRET=
    CLOUDINARY_CLOUD_NAME=
    CLOUDINARY_SECURE=true
    ```
4. You may then change the FILESYSTEM_DISK value to `cloudinary`
5. Use Storage class to upload, retrieve, delete etc.
