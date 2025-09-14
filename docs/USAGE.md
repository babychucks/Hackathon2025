> *This document serves as a template for you to write **usage** instructions for your project.* 

# Usage Guide

## ▶️ Running the Application
``` c
// TODO: Explain how to launch the project.
// Add commands or steps here.
```
``` bash
# 1. Clone the repository
git clone https://github.com/babychucks/Hackathon2025.git
cd Hackathon2025

# 2. Make sure Docker & Docker Compose are installed
docker --version
docker-compose --version

# 3. Start the containers (PHP + Apache + MySQL)
docker-compose up --build
```
Once it’s running, open:

Frontend → http://localhost:8082

Backend API → http://localhost:8082/backend/api.php
## 🖥️ How to Use
``` c
// TODO: Provide step-by-step usage instructions for judges/users.
```
1. Step 1 -> Do this
2. Step 2 -> Then this
3. Step 3 -> See the output/result

## 🎥 Demo
``` c
// TODO: Link your demo video and PowerPoint here
```
Check out the Demos: 
- [Demo Video](../demo/demo.mp4)
- [Demo Presentation](../demo/demo.pptx)

## 📌 Notes
``` c
// TODO: Add any special instructions, caveats, or tips
// for using your project.
```Default MySQL credentials are configured in docker-compose.yml.

The service name for the database is db (not localhost).

Always send requests as POST with JSON body. Opening the API in a browser (GET) will show errors.

If you see Cannot modify header information, it means some PHP error output occurred before JSON headers were sent. Check docker logs hackathon_web.

To reset the database, remove the volume:

docker-compose down -v
docker-compose up --build
