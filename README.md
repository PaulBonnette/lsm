## LSM - Laravel Server Manager

This Laravel project is written in PHP 8.4.  It is a set of "php artisan" console commands to make Laravel server management easy and secure.  

Right now I'm focusing on managing Droplets.  Hopefully in a few weeks I'll be done with Droplet management.  I'm might jump to autoinstall'ed Ubuntu servers or maybe Raspberry Pi's after than.  Good fun.

## Goal

A Linux Server Management (LSM) tool to help configure and manage multiple linux servers for Laravel projects.  It runs on your "PC" and manages many "SERVERS".  Written in PHP 8.4 it handles three groups of general tasks:

## 1 - Centralized Management - one "MANAGER" to manage them all.

One central "MANAGER" installation (usually your workstation) to manage all your servers:

- Upload LSM updates to the remote Servers. 
- Pull configuration changes from each remote server to the PC, as a backup.
- Push backups to the remote servers (for restoring to a website).

## 2 - Managing "SERVER"s - commands to help you manage and scan your servers for vulnerabilities.

The Laravel hosting server commands allows you to easily manage your server with standard configurations (hopefully). Like:

- Installing on a Droplet, in-house Ubuntu 24.04+ server or Raspberry Pi, 
- Install necessary packages and software, including: Letsencrypt, NTP server, nginx, postfix, PHP 8.4+, nmap, Cockpit and plugins, etc.
- Configure standard packages to work together for Laravel hosting.
- Evaluate any server for security holes and fix them automatically. 

## 3 - Managing Website Releases - commands for handling website releases.

- Manage multiple websites on a single server.
- Auto-generation of nginx configuration files with Letsencrypt certificates.
- Auto-registration of each website's artisan heart-beat, which creates an off-server backup.
- Backup restoration of Spatie-backup files with rollback support.
- Copying of an existing website with rollback support.
- Github update of an existing website with rollback support.

## Why LSM instead of GitHub Continuous Deployment?

- LSM should give you tighter security since GitHub does not need to know how to log into your server. (You <em>pull</em> the project from GitHub instead of GitHub <em>pushing</em> it.)
- Your server can remain on-premises, behind a firewall, while being locked down tightly, as if it were on the Internet.  This is perfect for a private application connected to an in-house database server or Raspberry Pi data-gathering modules spread throughout a facility.  (This may be a permanent arrangement or temporary as you migrate an application fully into Laravel.)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

