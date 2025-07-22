sudo apt update   
sudo apt install mysql -y
sudo systemctl restart mysql

  
sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf


CREATE USER 'newuser'@'%' IDENTIFIED BY 'newpassword';
GRANT ALL PRIVILEGES ON user_data.* TO 'newuser'@'%';
FLUSH PRIVILEGES;

-- Create the database if it does not exist
CREATE DATABASE IF NOT EXISTS user_data;

-- Use the database
USE user_data;

-- Create the users table if it does not exist
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL
);

-- Create MySQL user 'newuser' with password 'newpassword' and allow remote access
CREATE USER IF NOT EXISTS 'newuser'@'%' IDENTIFIED BY 'newpassword';

-- Grant all privileges on user_data to the newuser from any host
GRANT ALL PRIVILEGES ON user_data.* TO 'newuser'@'%';

-- Apply changes
FLUSH PRIVILEGES;
