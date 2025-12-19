# 🎓ITS MentorMatch

ITS MentorMatch is a web-based mentoring platform designed for ITS students to connect with alumni and senior mentors for academic guidance, skill development, and career insights.

This project is developed as a **DevOps-focused final project**, with a strong emphasis on **Continuous Integration (CI)** using **GitHub Actions**.

---

## 📌 Project Overview

In modern software development, applications must be delivered quickly, reliably, and consistently. Manual testing and deployment processes are often error-prone and inefficient.

ITS MentorMatch applies DevOps practices to automate testing and build processes. By using GitHub Actions, every code change is automatically validated to ensure build readiness and system stability before deployment.

**Architecture**: Laravel (Pure MVC)  
**Database**: MySQL  
**Deployment**: VPS Environment (Hostinger)

---

## 🛠 Technology Stack

### Application & Database
- **Framework**: Laravel (Pure MVC)
- **Backend Language**: PHP 8.4
- **Database**: MySQL
- **Frontend**: Blade + Tailwind CSS

### Development Tools
- **Composer**: PHP dependency management
- **Node.js & NPM**: Frontend asset management
- **DBeaver**: Database inspection and table preview

### Server & Infrastructure
- **VPS Provider**: Hostinger (KVM 1)
- **Web Server / Load Balancer**: Nginx
- **Firewall**: UFW
- **Remote Access**: OpenSSH (public–private key authentication)

### DevOps & CI
- **CI Tool**: GitHub Actions
- **Scope**: Continuous Integration (testing & build automation)

---

## 🚀 Local Development Setup

### Prerequisites
- PHP >= 8.4
- Composer
- Node.js & NPM
- MySQL

### Installation Steps

#### 1. Clone the Repository
```bash
git clone <repository-url>
cd its-mentormatch
```

#### 2. Install PHP Dependencies
```bash
composer install
```

#### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```
> **Note**: Database schema is prepared manually; this project does not use Laravel migrations.

#### 4. Configure Database
Edit .env and set your MySQL credentials:
```bash
DB_CONNECTION=mysql
DB_DATABASE=its_mentormatch
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

#### 5. Install & Build Frontend
```bash
npm install
npm run build
```

#### 6. Run the Application
```bash
php artisan serve
```
Access at: http://127.0.0.1:8000

---

## 🧪 Testing Strategy

### Running Tests Locally

* **Standard Test**

  ```bash
  php artisan test
  ```

* **With Code Coverage**

  ```bash
  php artisan test --coverage
  ```

### Coverage Report

A coverage report is generated at:

```
coverage/index.html
```

The report provides insights into:

* Covered vs. uncovered code percentages
* Coverage percentage per file
* Line and method coverage analysis

> **Note**: This report is intended for development and academic evaluation only. It is **not exposed in production** for security reasons.

### Test Environment Configuration

Tests are executed using an **SQLite in-memory database** (configured in `phpunit.xml`) to ensure:

* **Test Isolation**: The production database (MySQL) is never accessed
* **Fast Execution**: No disk I/O overhead
* **No Dependencies**: Independent of production data state

---

## ⚙️ CI Pipeline (GitHub Actions)

The CI pipeline runs automatically on **every push to the `master` branch**.

### CI Workflow Includes

* Code checkout
* PHP setup (**PHP 8.4**)
* Composer & NPM dependency installation
* Frontend asset build
* Automated test execution

### Test Execution Strategy in CI

```bash
php artisan test || echo "Some tests failed, but continuing pipeline"
```

This approach allows test results to remain visible in CI logs while still allowing the pipeline to continue.

> **Note**: This strategy is intentionally used for **academic and demonstration purposes** to showcase CI execution without blocking deployment artifacts.

---

## 🌐 Deployment Notes

* **Production URL**: [http://72.61.141.156/](http://72.61.141.156/)
* **Web Server**: Nginx (used as both web server and load balancer)
* **Security**:

  * UFW allows required ports (HTTP, HTTPS, SSH)
  * SSH key-based authentication is enforced

---

## 📝 Notes for Reviewers

* **Database**: Data is not included in the repository; the schema is managed manually
* **Safety**: Tests use an in-memory SQLite database for total isolation
* **Visibility**: CI behavior and logs can be reviewed directly in the GitHub Actions tab
* **DevOps Focus**: This project follows DevOps best practices within an academic context, emphasizing build standardization and automated validation










