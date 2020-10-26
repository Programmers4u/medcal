# MySQL

**How To Install MySQL on Ubuntu 20.04**

        sudo apt update
        sudo apt install mysql-server
        sudo mysql_secure_installation
        sudo mysql

        CREATE USER 'medcal'@'localhost' IDENTIFIED BY 'password';

        GRANT CREATE, ALTER, DROP, INSERT, UPDATE, DELETE, SELECT, REFERENCES, RELOAD on *.* TO 'medcal'@'localhost' WITH GRANT OPTION;

        FLUSH PRIVILEGES;

        >mysql \q
        >mysql -u medcal -p
        >mysql CREATE DATABASE medcal;
        >mysql \q
