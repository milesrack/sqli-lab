GRANT ALL PRIVILEGES ON *.* TO "root"@"%";
UPDATE mysql.user SET host="%" WHERE user="root";
DROP DATABASE IF EXISTS sqli_demo;
CREATE DATABASE sqli_demo;
CREATE TABLE sqli_demo.users(id INT AUTO_INCREMENT PRIMARY KEY, username TEXT, password TEXT, email TEXT);
INSERT INTO sqli_demo.users(username, password, email) VALUES ("admin", "CB_Cyb3rAdm1n#2023", "cbhscyber@gmail.com");
INSERT INTO sqli_demo.users(username, password, email) VALUES ("flag", "CBCYBER{5q1_1nj3c710n_3932130}", "example@example.com");
