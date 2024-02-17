# Architecture and TDD in Laravel-Vue Application

## Introduction
This report provides an overview of the architecture of our Laravel-Vue application and describes how we implemented Test-Driven Development (TDD) during its development. The key challenges and decisions made during design and development are detailed, as well as the processes and tools used to guarantee the quality of the code and the robustness of the application.

## Application Architecture
This application follows a client-server architecture, where the backend is developed with Laravel and the frontend with Vue.js. The main components of each part are described below:

## Backend (Laravel)
Controllers: Used to handle HTTP requests and orchestrate business logic.
Models: They represent data structures and define the relationships between them.
Routes: Define URLs and associated handlers to handle incoming requests.
Middleware: Used to filter and modify HTTP requests before they reach the controllers.

## Interface (Vue.js)
Components: Independent units of the user interface that can be reused throughout the application.
Routes: Defined using Vue Router to manage navigation between different views of the application.

Application State: Managed through Vuex to maintain a centralized and shared state between components.

Vuetify configuration:
I configure Vuetify using createVuetify, where I can pass custom options such as additional components and directives that you want to use in your application.

Creating Vue App: This is where you create the main Vue app instance with createApp. The use method is then used to add Vuex, Vue Router, CKEditor, and Vuetify to the application.

Mounting the application: Finally, the application is mounted on the element with the id #app in the DOM, which means that the application is started and made visible.

## Axios
Ensures that all HTTP requests sent from the application automatically include the authentication token in the authorization header, and handles unauthorized responses appropriately by removing the authentication token and redirecting the user to the login page.

## TDD implementation
During the development of our application, we follow a TDD approach to ensure code quality and system stability. Here is a summary of the key steps I followed:

-Writing Tests: Before writing code, write automated tests that describe the expected behavior of new features or functionalities.

-Execution of Tests: You run the tests to verify that they did not pass the test, which confirms the correct behavior.
Code Implementation: I wrote the minimum code necessary for the tests to pass.

-Refactoring: Once the tests pass, I have tried to refactor the code to improve its quality and readability, keeping the tests as a safety net to avoid regressions.

### Key Decisions and Challenges.

During development, I faced several challenges and made key decisions that will affect the architecture and implementation of the application. Some of these challenges are:
-The use of JWT, since I have only used laravel/sanctum
-Vuetify is something I'm still learning, I installed and mounted it globally on the frontend but I mostly use TailWind.css
-in my .env file I used an old email to test sending these for authentication and avoid the cors failure by Laravel.

### Conclusions
The combination of a well-defined architecture and the practice of TDD has been fundamental for this project. It has allowed me to develop a robust and scalable application, with a high level of reliability and maintainability.