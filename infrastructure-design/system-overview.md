# System Overview – AWS Secure Two-Tier Architecture

## 1. Introduction

This project implements a secure Two-Tier Web Application Architecture on AWS using two EC2 instances. The architecture separates the application layer (web server) from the data layer (database server) to improve security, scalability, and maintainability.

The application deployed is a dynamic Guestbook built using Apache, PHP, and MariaDB (MySQL-compatible).

---

## 2. Architecture Model

This solution follows a Two-Tier Architecture pattern:

- Tier 1: Presentation Layer (Web Server EC2)
- Tier 2: Data Layer (Database Server EC2)

The Web Server communicates with the Database Server using private IP communication within the same VPC.

The database is not publicly accessible.

---

## 3. AWS Infrastructure Components

### 3.1 Amazon EC2

Two EC2 instances are deployed:

1. Web Server Instance
   - Amazon Linux 2023
   - Apache (httpd)
   - PHP
   - Publicly accessible

2. Database Server Instance
   - Amazon Linux 2023
   - MariaDB Server
   - Private database access

---

### 3.2 Security Groups

Two separate Security Groups are implemented:

Web Server Security Group (web-server-sg)
- Port 22 (SSH) → Allowed from My IP
- Port 80 (HTTP) → Allowed from 0.0.0.0/0

Database Security Group (db-server-sg)
- Port 22 (SSH) → Allowed from My IP
- Port 3306 (MySQL) → Allowed only from web-server-sg

Security Group referencing ensures secure communication between tiers.

---

### 3.3 Networking

- Both EC2 instances are deployed within the same VPC.
- Communication between Web and Database happens using Private IP.
- The database does not have public exposure.

---

## 4. Application Workflow

1. User accesses the Web Server via Public IP.
2. Apache serves the PHP application.
3. User submits a message via form.
4. PHP application connects to MariaDB using private IP.
5. Data is inserted into the guestbook table.
6. Messages are retrieved and displayed dynamically.

---

## 5. Database Design

Database Name: myDatabase  
Table Name: guestbook  

Table Structure:

- id (INT, Primary Key, Auto Increment)
- name (VARCHAR)
- message (TEXT)

---

## 6. Security Considerations

- Database is isolated from public internet.
- MySQL port restricted to Web Server Security Group.
- SSH access restricted to trusted IP.
- Application and database are separated for layered security.

---

## 7. Benefits of This Architecture

- Improved security through tier isolation
- Better scalability (Web and DB can scale independently)
- Cleaner infrastructure design
- Production-style deployment model

---

## 8. Future Enhancements

- Replace EC2 database with Amazon RDS
- Add Application Load Balancer
- Implement Auto Scaling Group
- Enable HTTPS using ACM
- Deploy infrastructure using Terraform

---

## 9. Conclusion

This project demonstrates the practical implementation of a secure Two-Tier architecture on AWS using EC2 instances, private IP communication, and controlled network access through Security Groups.

It reflects real-world infrastructure design principles used in production environments.
