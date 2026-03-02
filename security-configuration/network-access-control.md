# Network Access Control – AWS Two-Tier Architecture

## 1. Objective

This document explains how network traffic is controlled and secured within the AWS Two-Tier Architecture project.

The goal is to ensure:

- Controlled inbound access
- 
- Restricted database exposure
- 
- Secure internal communication
- 
- Least privilege access model
  

---

## 2. Network Design Overview

The architecture uses the default AWS VPC and consists of:

- Web Server EC2 (Public-facing)
  
- Database EC2 (Private access only)
  

Communication Flow:

User → HTTP (Port 80) → Web Server  

Web Server → Private IP → Database (Port 3306)

Database is NOT exposed to the internet.

---

## 3. Security Groups Configuration

### 3.1 Web Server Security Group (web-server-sg)

Inbound Rules:

| Port | Protocol | Source       | Purpose        |
|------|----------|-------------|---------------|
| 22   | TCP      | My IP       | SSH Access     |
| 80   | TCP      | 0.0.0.0/0   | Public HTTP    |

Outbound Rules:

- Allow all outbound traffic (Default)

Purpose:

- Allow users to access web application
  
- Restrict SSH to trusted IP

---

### 3.2 Database Security Group (db-server-sg)

Inbound Rules:

| Port | Protocol | Source            | Purpose              |
|------|----------|------------------|----------------------|
| 22   | TCP      | My IP            | SSH Access           |
| 3306 | TCP      | web-server-sg    | MySQL from Web Tier  |

Outbound Rules:

- Allow all outbound traffic (Default)
  

Purpose:

- Prevent public database exposure
  
- Allow DB access only from Web Server
  

---

## 4. Private IP Communication

The Web Server connects to the Database using:

Example:

172.31.x.x (Private IP)

Benefits:

- Traffic remains inside VPC
  
- No public exposure of DB
  
- Improved security posture
  

---

## 5. Network Security Controls Applied

- Database EC2 has no public access on port 3306
  
- SSH access restricted to trusted IP
  
- Application and database isolated in separate tiers
  
- Security Groups enforce tier-to-tier communication

  
- No direct user-to-database connectivity allowed

---

## 6. Connectivity Validation

From Web Server:

telnet DB_PRIVATE_IP 3306

Expected:

Connection established

If connection fails:

- Verify Security Group rules
  
- Check MariaDB service status
  
- Confirm bind-address configuration
  
