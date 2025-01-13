# Project Management API

A simple Laravel-based **Project & Task Management API**, designed to run inside **Docker**.

## Requirements

- **Docker** (latest stable version)
- **Docker Compose** (latest stable version)

## Quick Start

**Clone the Repository**

```bash
git clone https://github.com/elite133713/project-management.git
cd project-management
```
**Copy & Edit Environment File**

•	Copy the example file:

```bash
cp .env.example .env
```

•	Update any relevant variables in the .env (database name, username, password, etc.).

•	By default, the Docker Compose setup will use the credentials configured in docker-compose.yml.

**Build & Start Containers**

```bash
docker-compose up --build -d
```

This command:

•	Builds images defined in docker-compose.yml.

•	Starts containers in the background.

**Install Dependencies, Generate Key**

After containers start, run the following inside the app container:
```bash
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
```

**Run Migrations & Seed Database**
```bash
docker-compose exec app php artisan migrate --seed
```

**Access the App**
The application is typically available at:
```
http://localhost
```

**Running Tests**

You can run tests (Feature/Unit) with:
```bash
docker-compose exec app php artisan test
```

## API Endpoints

| Method | Endpoint                           | Description                                |
|--------|------------------------------------|--------------------------------------------|
| **GET**    | `/api/projects`                    | List all projects (paginated)              |
| **POST**   | `/api/projects`                    | Create a new project                       |
| **GET**    | `/api/projects/{id}`               | Show a single project                      |
| **PUT**    | `/api/projects/{id}`               | Update a project                           |
| **DELETE** | `/api/projects/{id}`               | Delete a project                           |
| **GET**    | `/api/tasks`                       | List all tasks (paginated)                 |
| **GET**    | `/api/projects/{project_id}/tasks` | List tasks for a specific project          |
| **POST**   | `/api/projects/{project_id}/tasks` | Create a task under a project              |
| **GET**    | `/api/tasks/{id}`                  | Show a single task                         |
| **PUT**    | `/api/tasks/{id}`                  | Update a task                              |
| **DELETE** | `/api/tasks/{id}`                  | Delete a task                              |

### Useful Commands
•	Stop Containers
```bash
docker-compose down
```

•	Rebuild & Restart (e.g., if you change Docker config)
```bash
docker-compose up --build -d
```

•	Run Migrations Fresh
```bash
docker-compose exec app php artisan migrate:fresh --seed
```

### Troubleshooting
1.	Permissions: If you encounter file permission issues, you may need to chmod or chown directories (especially storage/ or bootstrap/cache/) before starting Docker.
2.	Port Conflicts: Change the exposed port in docker-compose.yml if port 80 is already in use (e.g., - "80:80").
3.	Logs: Check container logs for errors:
```bash
docker-compose logs app
docker-compose logs db
```

