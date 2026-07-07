
# IoT Workstation Access Control

A private web application for managing access to IoT-enabled workstations. This project provides a secure interface and backend workflow for authenticating and authorizing users who wish to access physical workstations equipped with IoT technologies.

## Features

- User authentication and authorization
- Admin dashboard for access management
- Role-based permissions (e.g., student, staff, admin)
- Access logs/tracking for security auditing
- Web-based interface for easy management (Laravel Blade templates)
  
## Getting Started

1. **Clone the repository**
   ```
   git clone https://github.com/ZaydiMucode/iot-workstation-access-control.git
   ```
2. **Install dependencies**
   ```
   composer install
   npm install
   ```
3. **Set up environment variables**
   - Copy `.env.example` to `.env` and set your configuration.

4. **Generate application key**
   ```
   php artisan key:generate
   ```

5. **Run migrations**
   ```
   php artisan migrate
   ```

6. **Serve the application**
   ```
   php artisan serve
   ```
   ```
   npm run dev
   ```
   Access the app at `http://localhost:8000`

## Contributors

- [ZaydiMucode](https://github.com/ZaydiMucode) 
- [DalmacioHan](https://github.com/DalmacioHan) 
- [Jhanrey16](https://github.com/Jhanrey16) 
- [Derk Andre](https://github.com/derkandre)
## License

This project is licensed under the MIT License. See [LICENSE](LICENSE) for details.

## Author

[ZaydiMucode](https://github.com/ZaydiMucode)
