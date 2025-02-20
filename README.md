<h1 align="center">
  🐘🎯 Hexagonal Architecture, Event Domain, DDD & CQRS in PHP
</h1>

<p align="center">
    <a href="#"><img src="https://img.shields.io/badge/PHP%208.1-777BB4?logo=php&logoColor=white" alt="Php 8.1"/></a>
    <a href="#"><img src="https://img.shields.io/badge/Symfony-6.4-purple.svg?style=flat-square&logo=symfony" alt="Symfony 8.1"/></a>
</p>

<p align="center">
  Example of a <strong>PHP application using Domain-Driven Design (DDD) and Command Query Responsibility Segregation
  (CQRS) principles</strong> keeping the code as simple as possible.
  <br />
  <br />
</p>

## 🚀 Environment Setup

### 🐳 Needed tools

1. Download the project from https://github.com/peirinhas/task-flow
2. Move to the project folder: `cd task-flow`

### 🔥 Application execution

1. Download all images to bring up the project: `make build`
2. Bring up the project: `make start`
3. Setup project (Install all the dependencies && migrations): `make setup`

### ✅ Tests execution

1. Execute PHPUnit tests: `make test`

### 💊 Utils (Endpoints & connection BBDD)

You can execute the http requests from  `task-flow/endpoints_api_test.http` [step by step information inside the file]

If want to check the database: <br>
`Host: localhost` <br>
`Port: 3307` <br>
` User: root` <br>
`Password: root` <br>
`Schema: core`

## 👩‍💻 Project explanation

The project consists of a task manager that allows registered users to manage and update their tasks. It also offers the
possibility of obtaining a list of metrics, facilitating the monitoring and analysis of task progress.

### ⛱️ Bounded Contexts

- **Public**: Place where users can register and to do login
- **Backoffice**: Place where user can manage your tasks (CRUD) and get list all your metrics

### 👷🏻‍ Potential Improvements

Potential Improvements

###### Functional Tasks:

- Add comments to tasks.
- Log metrics related to the comments.
- Allow file attachments to tasks.
- Support the creation of subtasks within tasks.
- Send task reminders via email.
- Implement filters and sorting options for tasks.
- Enable the assignment of tasks to other users.
- Manage user roles to restrict access and actions based on the role.
- Implement a task flow to restrict actions based on the task's current status.

###### Tech Tasks:

- Implement the Criteria design pattern to enhance task querying and filtering, making it more flexible.
- Ensure the robustness of aggregate IDs by adding a unique prefix to each aggregate, ensuring consistency and
  uniqueness.
- Develop a generic database type to manage enumeration types, improving maintainability and scalability.
- Migrate metrics persistence from MySQL to Redis, optimizing performance for fast reads and efficient processing.
- Replace Symfony's in-memory usage with RabbitMQ for message handling, improving scalability and reliability.
- Integrate Elasticsearch to optimize search and filtering performance, especially with large volumes of data.
