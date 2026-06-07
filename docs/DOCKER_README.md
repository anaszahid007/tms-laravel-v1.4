# Simplified Docker Setup

This project uses a simplified Docker environment for both development and production. It removes Nginx for faster reloads and easier management.

## 🚀 How to Start

1. **Stop any local servers** (close existing terminals running `php artisan serve` or `npm run dev`).
2. **Start the containers**:
   ```bash
   # Stop current containers and remove the volumes to force re-initialization
   docker-compose down -v
   
   # Rebuild and start everything
   docker-compose up -d --build
   ```
   *(The first time will take a few minutes to build the application image)*

## 🛠 Running Commands

Since the app is in a container, you must run commands inside the container:

| Action | Command |
| :--- | :--- |
| **Run Migrations** | `docker compose exec app php artisan migrate` |
| **Clear Cache** | `docker compose exec app php artisan cache:clear` |
| **Install Package** | `docker compose exec app composer require ...` |
| **Node/NPM** | `docker compose exec app npm run dev` |

## 🌐 Access the Sites
- **Web App:** [http://localhost:8000](http://localhost:8000)
- **Database:** host: `db`, port: `5432`
- **Redis:** host: `redis`, port: `6379`

## ⚠️ Performance Tips
If you are on Windows, ensure you are running this project from inside a **WSL2** directory (e.g., `\\wsl$\Ubuntu\home\user\project`) for the best performance and fastest reloads.
