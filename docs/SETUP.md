> *This document serves as a template for you to write **setup** instructions for your project.* 

> Depending on the scale/complexity of your project, it may prove beneficial to have a **Python/Batch/Bash** script in the `scripts/` directory which *automatically sets-up* the project.

# Setup Instructions

Follow the steps below to set up and run the project. (Example)

---

## 📦 Requirements
``` c
// TODO: List software, runtimes, frameworks, and or dependencies
// along with instructions on how to set each up.
```
Requirements

Docker v20+ → Install Docker

Docker Compose v2+ → Install Docker Compose

Git → Install Git

(Optional) cURL or Postman → for testing API endpoints
---

## ⚙️ Installation
``` bash
# 1. Clone the repository
git clone https://github.com/babychucks/Hackathon2025.git
cd Hackathon2025

# 2. Copy the .env.example to .env (edit values if needed)
cp .env.example .env

# 3. Build and start the containers
docker-compose up --build

```

## ▶️ Running the Project
``` bash
# Start services in detached mode
docker-compose up -d

# Stop services
docker-compose down

# Rebuild if you change Dockerfile or composer.json
docker-compose up --build
Frontend/Dashboard → http://localhost:8080

Backend API → http://localhost:8080/backend/api.php

MySQL DB available at host db:3306 inside Docker network<insert run command here> # Or an explanation on what to do
```
