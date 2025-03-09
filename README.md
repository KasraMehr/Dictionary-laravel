![logo](https://github.com/user-attachments/assets/35ae7237-a1f6-4f48-98f3-9fa0ee6949cc)

# Modern Dictionary (main part)

## Introduction
This project is part of a larger system that consists of multiple interconnected services, ensuring high scalability and modularity. This specific module focuses on handling core application functionalities using Laravel for the backend and Vue.js for the frontend. The architecture allows seamless integration with other microservices within the ecosystem.

This project has been primarily developed by **Kasra Mehr**.

## Core Functionalities
### Backend (Laravel)
Laravel handles the core functionalities of the dictionary system, including:
- Word management (CRUD operations on dictionary entries)
- User account management and authentication
- API development for seamless frontend integration
- Real-time updates and caching

### Database
We use:
- **MySQL** for relational data storage
- **Redis** for caching and real-time messaging

### Frontend (Vue.js + Vite)
The frontend is built with Vue.js and Vite, focusing on fast rendering and high modularity for easier scalability.
- **Vue.js** handles the user interface and integrates seamlessly with the backend API for real-time data fetching and updates.
- **Vite** ensures fast bundling and hot-reloading during development.

## Teams & Collaboration
This project is developed by a dedicated team of backend, frontend, and DevOps engineers who work collaboratively to maintain and improve the system. Our team follows agile methodologies and uses CI/CD pipelines to ensure smooth deployments.

## Technologies Used
- **Backend:** Laravel 10.x
- **Frontend:** Vue.js 3
- **Database:** MySQL / PostgreSQL / Redis
- **Authentication:** Laravel Sanctum / JWT
- **Styling:** Tailwind CSS / Bootstrap
- **State Management:** Pinia / Vuex

## Installation & Setup
### Prerequisites
Ensure you have the following installed on your system:
- PHP 8.x
- Composer
- Node.js & npm / yarn
- MySQL / PostgreSQL

### Backend Setup
```bash
# Clone the repository
git clone https://github.com/your-repo.git
cd your-repo

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env and migrate
php artisan migrate --seed

# Start the development server
php artisan serve
```

### Frontend Setup
```bash
# Install dependencies
npm install

# Run the development server
npm run dev
```

## Usage
Once both backend and frontend servers are running, you can access the application at:
```
http://localhost:8000
```

## API Documentation
For detailed API documentation, please refer to our main documentation at:
```
https://docs.modern-dictionary.com
```
Additionally, you can test available API endpoints locally at:
```
http://localhost:8000/api/documentation
```

## Deployment
### Backend
```bash
php artisan config:cache
php artisan route:cache
php artisan migrate --force
```

### Frontend
```bash
npm run build
```

## Contributing
We welcome contributions! If you'd like to contribute, please follow the contribution guidelines outlined in the main documentation. (not done yet)
