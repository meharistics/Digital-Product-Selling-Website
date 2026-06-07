
# Digital Product Selling Platform 🚀

### *Object-Oriented & Session-Driven E-Commerce Infrastructure*

---

##  Project Architecture Overview

This web application is a relational-database-driven digital marketplace built to manage user workflows, track inventory nodes, and execute dynamic product listing arrays.

The system isolates public browsing routes from restricted administrative backend files, utilizing state persistence, secure form handling, and algorithmic content delivery to prevent product duplication across consecutive UI layers.

---

##  Core Engineering Stack

* **Development Environment:** Visual Studio Code (VS Code)
* **Server Deployment:** XAMPP Local Server Suite (Apache HTTP Engine)
* **Backend Runtime:** PHP 8.x (Procedural & Session-Driven logic blocks)
* **Database Management System:** MySQL Relational Database
* **Frontend Controller Layer:** Vanilla JavaScript (ES6+ Asynchronous DOM Manipulation), HTML5, Bootstrap 5

---

##  System Logic & Functional Working Components

### 1. Database-Driven Content Scrambling Engine 

* **The Logic:** To optimize catalog visibility and prevent user fatigue, the marketplace landing page utilizes dual-array database parsing.
* **The Code Mechanics:** The application executes a standard query statement against the `products` table, pulling active vectors into a master array.
* **Algorithmic Disjunction:** The "Featured Track" processes this array sequentially. Simultaneously, the system instantiates an isolated duplicate array for the lower dashboard grid and applies PHP's native `shuffle()` algorithm. This ensures randomized database entry distribution on every document reload state.

### 2. Client-Side DOM Filtering Hub (No-Refresh Architecture) 

* **The Working:** Sub-navbar category navigation runs on an active client-side dataset observer matrix rather than resource-heavy server-side query requests.
* **The Code Mechanics:** Product cards are injected into the DOM with explicit `data-category` dataset attributes linked to their database tables. JavaScript click event listeners capture target category tokens, looping through the DOM node tree to instantly flip style visibility parameters (`display: none` / `display: block`) across multiple view ports simultaneously.
* **Empty-State Safety Block:** The engine monitors visible node counts; if structural array filtering returns zero results, an exception handler overrides the layout to render a fallback layout block.

### 3. Server-Side Session Validation & Access Control 

* **The Working:** Strict role-based validation acts as a structural gatekeeper for administrative backend routes.
* **The Code Mechanics:** High-privileged files run an active validation sequence utilizing PHP global arrays (`$_SESSION`).
* **Execution Guard:** The controller tests for a valid admin permission assignment string before executing any HTML rendering. If unauthenticated scripts attempt direct access via URL hijacking, the server throws an execution intercept, kills the current process line, and issues an immediate header redirection string back to the gateway login interface.

### 4. Relational CRUD Operations & Action Isolation 

* **The Working:** The administrative interface runs full Create, Read, Update, and Delete actions bound to your relational database table rows.
* **The Code Mechanics:** Every product entry is rendered with a strict identifier reference binding (`?id=<?= $p['id'] ?>`).
* **State Control Locks:** To bypass framework conflicts where default anchor actions cause button rendering failures during active selection cycles, explicit pseudo-class states (`:hover`, `:focus`, `:active`) are isolated via stylesheet layout controllers to ensure unyielding state tracking.

---

## 💻 Local Installation, Setup & Initialization

1. **Deploy Project Directory:**
Extract repository files directly into your server stack:
`C:\xampp\htdocs\digital-store\`
2. **Initialize Database Relational Schema:**
* Start **Apache** and **MySQL** modules inside your XAMPP Control Panel.
* Open a browser configuration portal at `http://localhost/phpmyadmin/`.
* Provision a empty database schema named `digital_store` and import your SQL source file.


3. **Establish Connection Parameters:**
Verify your connection configurations inside your root `includes/db.php` file match your active server runtime environment:
```php
$conn = mysqli_connect("localhost", "root", "", "digital_store");

```



```

4. **Runtime Access Routes:**
   * **Marketplace Discovery Front:** `http://localhost/digital-store/index.php`
   * **Admin Management Dashboard:** `http://localhost/digital-store/admin/dashboard.php`

---

## 👥 Software Engineering & Development Team

| Name | Roll Number | Primary Core Assignment |
| :--- | :--- | :--- |
| **Mehar Ali** | 2024F-BCE-249 | Lead Frontend Logic Architect & Role Security Controller |
| **Umair** | 2024F-BCE-070 | Backend Systems Architect & Array Engine Engineer |
| **Anas** | 2024F-BCE-095 | Database Administrator (DBA) & Relational Schema Mapping |

---
*Developed as an engineering project assessment milestone under VS Code environment deployment.*

```
