## LSM - Laravel Server Manager - Status=Started

This project has just begun.  Don't bother looking - yet.

## Goal

A Linux Server Management (LSM) tool to help configure and manage multiple linux servers for Laravel projects.  It runs on your "PC" and manages many "SERVERS".  Written in PHP 8.4 it handles three groups of general tasks:

## 1 - Centralized Management - one "PC" to manage them all.

One central PC (usually your workstation) manages your servers by helping you:

- Upload LSM updates to the remote Servers. 
- Pull configuration changes from each remote server to the PC as a backup.
- Push backups to the remote servers.

## 2 - Managing Servers - commands to help you manage and scan your server for vulnerabilities.

The Laravel hosting server is usually a Droplet, but I hope to allow other server types in the future. This project allows the user to do the following, starting from a bare-bones droplet:

- Install necessary packages and software, including: Letsencrypt, NTP server, nginx, postfix, PHP 8.4+, nmap, Cockpit and plugins, etc.
- Configure necessary packages, including firewall, server certificates, etc.
- Evaluate any server for security holes and fix them automatically. This includes properly configuring the ufw firewall to only allow necessary traffic, etc.
- Manage websites deployments

Managing Websites & Deployments

## 3 - Managing Website Releases - commands for handling website releases.

- Manage multiple websites on a single server.
- Auto-generation of nginx configuration files with Letsencrypt certificates.
- Backup restoration of spatie-backup files with rollback support.
- Copying of an existing website with rollback support.
- Github update of an existing website with rollback support.

## Why LSM instead of GitHub Continuous Deployment?

- GitHub Continuous Deployment is difficult to impliment behind a firewall.
- Tighter security since GitHub does not need to know how to log into your server. (You pull the project from GitHub instead of pushing it.)
- Your server can remain on-premises, even behind a firewall.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
