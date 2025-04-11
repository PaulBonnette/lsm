This project is not usable at this time. Check back shortly. I hope to have it functional in a few months.

LSM - Laravel Server Manager

Managing a server properly requires a great deal of specialized knowledge. Additionally it can be easy to make a mistake and leave a back door open on a server. LSM assists in managing multiple servers, quickly installing the necessary software packages, configuring it and locking it down against intrusion. This is not an easy task. Even when it is, it's easy to make a mistake. LSM is here to help.  (No guarantees)
Definitions

- PC - the computer which manages the Laravel-hosting servers. Usually this is your workstation.
- Server - the server, usually a droplet, which hosts a laravel website. There can be any number of servers. Eventually I will be supporting other server types.

# Central "PC" Manager

One central PC (usually your workstation) manages your servers by helping you:

- Upload LSM updates to the remote Servers
- Pull configuration changes from each remote server to the PC as a backup
- Manage many remote servers

Managing Servers

The Laravel hosting server is usually a Droplet, but I hope to allow other server types in the future. This project allows the user to do the following, starting from a bare-bones droplet:

- Install necessary packages and software, including: Letsencrypt, NTP server, nginx, postfix, PHP 8.3+, nmap, etc.
- Configure necessary packages, including firewall, server certificates, etc.
- Evaluate any server for security holes and fix them automatically. This includes properly configuring the ufw firewall to only allow necessary traffic, etc.
- Manage websites deployments

Managing Websites & Deployments

This project supports website management including:

- Multiple websites on a single server with different ports.
- Auto-generation of nginx configuration files with Letsencrypt certificates.
- Backup restoration of spatie-backup files with rollback support.
- Copying of an existing website with rollback support.
- Github update of an existing website with rollback support.

LSM instead of GitHub Continuous Deployment

- GitHub Continuous Deployment is difficult to impliment behind a firewall.
- LSM means you don't need to give GitHub your credentials. We are pulling the project from GitHub instead of pushing it.
- Your server can remain on-premises.
- Your server can be hosted behind a firewall with no direct public access.

