Domain Expiration Management System - Documentation
Overview
This is a CodeIgniter 3 based Domain Expiration Management System that allows users to track domain expiration dates using WHOIS API data. The system provides domain monitoring, expiration alerts, and management features.

Features
Domain expiration tracking

WHOIS API integration

Automatic domain data refresh

Expiration alerts (30/15/7 days before expiry)

Bulk domain management

Email notifications

Installation
Prerequisites
PHP 7.0 or higher

MySQL 5.6 or higher

CodeIgniter 3.1.11

Composer (for optional dependencies)

WHOIS API key (from whoisapi.whois.com)

Setup Instructions
Clone the repository

bash
git clone https://github.com/yourusername/domain-expiration-system.git
cd domain-expiration-system
Database Setup

Create a MySQL database

Import the SQL file:

bash
mysql -u username -p database_name < database/schema.sql
Configuration

Rename application/config/config.sample.php to application/config/config.php

Rename application/config/database.sample.php to application/config/database.php

Update configuration files with your settings

API Key Setup

Add your WHOIS API key to application/config/whoisapi.php

Cron Job Setup
Add this to your crontab for daily domain checks:

bash
0 0 * * * /usr/bin/php /path/to/your/installation/index.php cron check_domains
File Structure
domain-expiration-system/
├── application/
│   ├── config/          # Configuration files
│   ├── controllers/     # Application controllers
│   ├── core/           # Core extensions
│   ├── helpers/        # Helper functions
│   ├── libraries/      # Custom libraries
│   ├── models/         # Database models
│   ├── views/          # View templates
│   └── language/       # Language files
├── system/             # CodeIgniter system files
├── assets/             # CSS, JS, images
├── database/           # Database schema and migrations
├── tests/              # Unit tests
├── .gitignore          # Git ignore rules
├── index.php           # Front controller
├── LICENSE             # License file
└── README.md           # Project readme
API Integration
The system integrates with the WhoisAPI (whoisapi.whois.com). You'll need to:

Sign up for an account at whoisapi.whois.com

Obtain your API key

Add it to application/config/whoisapi.php

Usage
Adding Domains
Navigate to /domains/add

Enter the domain name (e.g., example.com)

The system will automatically fetch WHOIS data

Managing Domains
View all domains: /domains

Edit domain: /domains/edit/{id}

Refresh WHOIS data: /domains/refresh/{id}

Delete domain: /domains/delete/{id}

Checking Expiring Domains
View domains expiring within 30 days: /domains/check_expiring

Cron Jobs
The system includes a cron job controller for automatic domain checks:

bash
# Daily domain check
0 0 * * * /usr/bin/php /path/to/installation/index.php cron check_domains
Email Notifications
Configure email settings in application/config/email.php. The system will send notifications when:

A domain is about to expire (30/15/7 days before)

There's an error checking a domain

Customization
Adding New Fields
To add new fields to the domain tracking:

Add the column to the domains table

Update the Domain_model

Update the views and controllers

Changing Alert Thresholds
Modify the get_expiring_domains() method in Domain_model.php to change alert thresholds.

Troubleshooting
Common Issues
API Limit Reached

Solution: Upgrade your WHOIS API plan or implement caching

Domain Not Found

Solution: Check the domain spelling or try manual entry

Email Not Sending

Solution: Verify SMTP settings in email.php

Contributing
Fork the repository

Create a new branch (git checkout -b feature-branch)

Commit your changes (git commit -am 'Add new feature')

Push to the branch (git push origin feature-branch)

Create a new Pull Request

License
This project is licensed under the MIT License - see the LICENSE file for details.

Support
For support, please open an issue on GitHub or contact the maintainer.
