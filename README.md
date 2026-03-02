
🚀 AWS-Two-Tier-Architecture-Project

________________________________________

This project demonstrates a secure Two-Tier Architecture deployed on AWS using two EC2 instances.

The application is a dynamic Guestbook built with Apache, PHP, and MariaDB (MySQL-compatible) where users can submit and view messages stored in a private database.
________________________________________
🏗 Architecture Overview

This project follows a Two-Tier model:

•	Presentation Layer → Web Server EC2

•	Data Layer → Database Server EC2

The Web Server communicates with the Database Server using Private IP communication within the same VPC, ensuring secure internal connectivity.
________________________________________
📊 Architecture Diagram



________________________________________
☁️ AWS Services Used (Where & Why)

AWS Service	Used In	Purpose
Amazon EC2	Web Server + DB Server	Host application & database
Security Groups	Both EC2 Instances	Firewall rules (Port control)
VPC (Default)	Network Layer	Private IP communication
Elastic IP / Public IP	Web Server	Public access via HTTP
IAM Key Pair	SSH Access	Secure server login
________________________________________
⚙️ Architecture Components
________________________________________
🖥 Web Server EC2

Service Used: Amazon EC2

OS: Amazon Linux 2023

Installed Components:

•	Apache (httpd)

•	PHP

•	php-mysqlnd (MySQL driver)


Network Configuration:

•	Public IP enabled

•	Port 80 open to internet

Security Group: web-server-sg
Port	Purpose	Source
		
22	SSH	My IP
		
80	HTTP	0.0.0.0/0
		
________________________________________
🗄 Database Server EC2

Service Used: Amazon EC2

OS: Amazon Linux 2023

Installed Components:

•	MariaDB Server (MySQL-compatible)

Database Configuration:

•	Database: myDatabase

•	Table: guestbook


Security Group: db-server-sg

Port	Purpose	Source
22	SSH	My IP
3306	MySQL	web-server-sg only
________________________________________
🔐 Security Design

•	Database is NOT publicly accessible

•	MySQL Port 3306 restricted using Security Group referencing

•	Private IP communication inside same VPC

•	SSH access limited to trusted IP

•	Logical separation of Web and Database tiers
________________________________________
🧰 Technologies Used

Cloud Layer

•	AWS EC2

•	Security Groups

•	VPC Networking

Operating System

•	Amazon Linux 2023

Web Layer

•	Apache (httpd)

•	PHP
Database Layer

•	MariaDB (MySQL-compatible)

•	SQL (DDL & DML commands)

Access & Management

•	SSH

•	Systemctl (Service management)

•	MySQL CLI

________________________________________

🌟 Application Features

•	Users submit Name & Message

•	Data stored securely in database

•	Messages dynamically retrieved

•	Private backend communication

•	Secure access control via Security Groups
________________________________________
🎓 Learning Outcomes

•	Deploying multiple EC2 instances

•	Designing secure Two-Tier Architecture

•	Configuring Security Groups with restricted access

•	Implementing Private IP database communication

•	Installing & managing Apache and MariaDB

•	Troubleshooting network connectivity issues

•	Understanding infrastructure-level security isolation
________________________________________

👤 Author

Ritik Mohadikar

AWS Secure Two-Tier Architecture Project

