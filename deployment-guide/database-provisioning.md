
# Database Provisioning Guide – MariaDB on AWS EC2

## 1. Objective

This document explains how to provision and configure the Database Tier for the AWS Two-Tier Architecture project.

The database server is hosted on an EC2 instance running Amazon Linux 2023 and uses MariaDB (MySQL-compatible).

---

## 2. EC2 Instance Creation (AWS Console Steps)

1. Login to AWS Console
2. Navigate to EC2
3. Click "Launch Instance"
4. Configure as follows:

Instance Name:
    sql-server

AMI:
    Amazon Linux 2023

Instance Type:
    t2.micro (Free tier eligible)

Key Pair:
    Select existing key pair

Network Settings:
    VPC: Default VPC
    Security Group: db-server-sg

Security Group Inbound Rules:
    - SSH (22) → My IP
    - MySQL/Aurora (3306) → Source: web-server-sg

5. Click "Launch Instance"

---

## 3. Connect to Database Server

Use SSH:
ssh -i your-key.pem ec2-user@DB_PUBLIC_IP


4. Install MariaDB Server
   
sudo dnf update -y

sudo dnf install mariadb105-server -y

________________________________________
5. Start and Enable MariaDB Service
   
sudo systemctl start mariadb

sudo systemctl enable mariadb

sudo systemctl status mariadb

Verify service is:

active (running)

________________________________________
6. Configure MariaDB for Remote Access
   
Edit configuration file:

sudo nano /etc/my.cnf.d/mariadb-server.cnf

Find the line:

#bind-address=0.0.0.0

Remove the #:

bind-address=0.0.0.0

Save and exit.

Restart MariaDB:

sudo systemctl restart mariadb

________________________________________
7. Secure Initial Installation (Optional but Recommended)
   
sudo mysql_secure_installation

Follow prompts:

•	Set root password

•	Remove anonymous users

•	Disallow remote root login

•	Remove test database

•	Reload privileges

________________________________________
8. Create Database and Table
   
Login to MariaDB:

sudo mysql

Create database:

CREATE DATABASE myDatabase;

USE myDatabase;

Create guestbook table:

CREATE TABLE guestbook(

    id INT AUTO_INCREMENT PRIMARY KEY,
    
    name VARCHAR(100) NOT NULL,
    
    message TEXT NOT NULL
    );

________________________________________
9. Create Application Database User
    
Create user for Web Server connection:

CREATE USER 'Ritik'@'%' IDENTIFIED BY 'Ritik@123';

GRANT ALL PRIVILEGES ON myDatabase.* TO 'Ritik'@'%';

FLUSH PRIVILEGES;

EXIT;

Note:

The '%' allows connection from the Web Server EC2 via private IP.

________________________________________
10. Validate Database Configuration
    
Check database exists:

sudo mysql -e "SHOW DATABASES;"

Check table exists:

sudo mysql -e "USE myDatabase; SHOW TABLES;"

Expected output:

guestbook

________________________________________
11. Test Network Connectivity from Web Server
    
From Web EC2 instance:

telnet DB_PRIVATE_IP 3306

If connected:

Database network access is properly configured.

If connection refused:

Verify Security Group rules and bind-address configuration.

________________________________________
12. Security Best Practices Applied
    
•	Database is not publicly accessible

•	Port 3306 restricted to web-server-sg

•	SSH limited to trusted IP

•	Private IP communication within VPC

•	Separate security groups per tier

________________________________________
13. Troubleshooting Guide
 
If MariaDB fails to start:

sudo systemctl status mariadb

sudo journalctl -xe

If connection refused:

•	Check Security Group inbound rule

•	Check bind-address configuration

•	Ensure service is running

If access denied:

•	Verify database user and password

•	Confirm privileges granted properly
