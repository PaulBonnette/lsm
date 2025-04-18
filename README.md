## LSM - Laravel Server Manager

This project has just begun.  Don't bother looking - yet.  It is a set of "php artisan" console commands.

## Goal

A Linux Server Management (LSM) tool to help configure and manage multiple linux servers for Laravel projects.  It runs on your "PC" and manages many "SERVERS".  Written in PHP 8.4 it handles three groups of general tasks:

## 1 - Centralized Management - one "MANAGER" to manage them all.

One central PC (usually your workstation) manages your servers by helping you:

- Upload LSM updates to the remote Servers. 
- Pull configuration changes from each remote server to the PC, as a backup.
- Push backups to the remote servers (for restoring to a website).

## 2 - Managing "SERVER"s - commands to help you manage and scan your servers for vulnerabilities.

The Laravel hosting server is usually a Droplet or in-house server, but I hope to allow other server types in the future. This project allows the user to do the following:

- Droplet, in-house server, or Raspberry Pi
- Install necessary packages and software, including: Letsencrypt, NTP server, nginx, postfix, PHP 8.4+, nmap, Cockpit and plugins, etc.
- Configure standard packages and manage standard package set.
- Evaluate any server for security holes and fix them automatically. This includes properly configuring the ufw firewall to only allow necessary traffic, etc.

## 3 - Managing Website Releases - commands for handling website releases.

- Manage multiple websites on a single server.
- Auto-generation of nginx configuration files with Letsencrypt certificates.
- Backup restoration of spatie-backup files with rollback support.
- Copying of an existing website with rollback support.
- Github update of an existing website with rollback support.

## Why LSM instead of GitHub Continuous Deployment?

- LSM should give you tighter security since GitHub does not need to know how to log into your server. (You <em>pull</em> the project from GitHub.)
- Your server can remain on-premises, behind a firewall, while being locked down tightly, as if it were on the Internet.  This is perfect for a private application connected to an in-house database server.  This may be a permanent arrangement or temporary as you migrate an application fully into Laravel.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
