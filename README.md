# Jamia Shere Rabbani Portal

[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![PHP Version](https://img.shields.io/badge/PHP-8.2-blue)](https://www.php.net/)
[![Node Version](https://img.shields.io/badge/Node-18-green)](https://nodejs.org/)
[![TailwindCSS Version](https://img.shields.io/badge/Tailwind-4.1.12-blue)](https://tailwindcss.com/)
[![Vite Version](https://img.shields.io/badge/Vite-7.1.3-purple)](https://vitejs.dev/)
[![CI Workflow](https://github.com/abubakar0320/Jamia-shere-rabbani/actions/workflows/ci.yml/badge.svg)](https://github.com/abubakar0320/Jamia-shere-rabbani/actions)
[![CodeQL](https://github.com/abubakar0320/Jamia-shere-rabbani/actions/workflows/codeql-analysis.yml/badge.svg)](https://securitylab.github.com/tools/codeql)

---

## Overview

A **dynamic web portal** for **Jamia Shere Rabbani**, Mananwala, Pakistan.  
Supports admissions, authentication, results, gallery, downloads, and contact features.  
Optimized for **performance**, **maintainability**, and **security**.

---

## Table of Contents

- [Overview](#overview)  
- [Features](#features)  
- [Tech Stack](#tech-stack)  
- [Installation & Local Development](#installation--local-development)  
- [Project Structure](#project-structure)  
- [Environment Setup](#environment-setup)  
- [Screenshots](#screenshots)  
- [Advanced Usage](#advanced-usage)  
- [Contributing](#contributing)  
- [Changelog](#changelog)  
- [Future Improvements](#future-improvements)  
- [License](#license)  
- [Contact](#contact)  

---

## Features

- **Admissions Forms** with validations  
- **User Authentication** (login/register/logout)  
- **Results Display**  
- **Gallery Page** with image uploads  
- **Contact & Downloads**  
- **Admin Panel** (planned for role-based access)  
- **CI/CD Workflows** with GitHub Actions  
- **CodeQL Security Scanning** integrated  

---

## Tech Stack

- **Back-end:** PHP 8.2+, Composer  
- **Front-end:** HTML, Tailwind CSS 4.1.12, JavaScript, Vite 7.1.3  
- **Database:** MySQL 8+  
- **Dev Tools:** Node.js 18, npm  
- **CI/CD:** GitHub Actions  

---

## Installation & Local Development

```bash
# Clone repo
git clone https://github.com/abubakar0320/Jamia-shere-rabbani.git
cd Jamia-shere-rabbani

# Install PHP dependencies
composer install

# Copy and configure environment
cp .env.example .env
# Edit .env variables (DB, APP_KEY, etc.)

# Install JS dependencies
npm install

# Start development server
php -S localhost:8000
