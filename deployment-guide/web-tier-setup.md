web-tier-setup.md
# Web Tier Setup Guide – Apache & PHP on AWS EC2

## 1. Objective

This document explains how to provision and configure the Web Tier for the AWS Two-Tier Architecture project.

The Web Server is hosted on an EC2 instance running Amazon Linux 2023 and serves a dynamic PHP-based Guestbook application.

---

## 2. EC2 Instance Creation (AWS Console – Click-by-Click)

1. Login to AWS Console
2. Search → EC2
3. Click "Launch Instance"

### Configure Instance:

Name:
    web-server

AMI:
    Amazon Linux 2023

Instance Type:
    t2.micro (Free Tier)

Key Pair:
    Select existing key pair

Network Settings:
    VPC: Default VPC
    Auto-assign Public IP: Enabled
    Security Group: web-server-sg

### Security Group Inbound Rules:

- SSH (22) → Source: My IP
- HTTP (80) → Source: 0.0.0.0/0

Click "Launch Instance"

---

## 3. Connect to Web Server

Use SSH:


ssh -i your-key.pem ec2-user@WEB_PUBLIC_IP

4. Update Server Packages
   
sudo dnf update -y

6. Install Apache (httpd)
   
sudo dnf install httpd -y


Start Apache:

sudo systemctl start httpd

Enable on boot:

sudo systemctl enable httpd

Verify status:

sudo systemctl status httpd

Expected:

active (running)

6. Install PHP & MySQL Driver
   
sudo dnf install php php-mysqlnd -y

Restart Apache:

sudo systemctl restart httpd

Verify PHP installation:

php -v

7. Prepare Web Directory

Navigate to web root:

cd /var/www/html

Remove default Apache page (if exists):

sudo rm -f index.html

8. Create Application File

Create index.php:

sudo nano index.php

Paste the php code which is application repo:


IMPORTANT:

Replace DB_PRIVATE_IP with the Private IP of the Database EC2 instance.

Save and exit:

CTRL + O → Enter

CTRL + X


9. Restart Apache After Code Deployment

sudo systemctl restart httpd

12. Validate Network Connectivity to Database

From Web Server:

telnet DB_PRIVATE_IP 3306

If connected:

Network communication is successful.

If connection refused:

Check Security Group rules and DB bind-address configuration.

11. Test Application

Open browser:

http://WEB_PUBLIC_IP

Expected:

Guestbook form loads

Message submission works

Messages display dynamically

12. Security Controls Applied

HTTP exposed to internet (Port 80)

SSH restricted to trusted IP

Database access via private IP only

Application and Database separated
