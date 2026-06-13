CREATE DATABASE bnpl_system;
USE bnpl_system;

-- جدول فروشگاه‌ها
CREATE TABLE stores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    store_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- جدول تراکنش‌ها
CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    store_id INT NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending','paid','overdue') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (store_id) REFERENCES stores(id) ON DELETE CASCADE
);

-- نمونه داده‌ها (فروشگاه‌ها)
INSERT INTO stores (store_name, email, password) VALUES
('فروشگاه لباس مد', 'mod@shop.com', MD5('123456')),
('بوتیک شیک', 'shik@shop.com', MD5('123456'));

-- نمونه داده‌ها (تراکنش‌ها)
INSERT INTO transactions (store_id, customer_name, amount, status) VALUES
(1, 'علی محمدی', 2500000, 'pending'),
(1, 'مریم احمدی', 1800000, 'paid'),
(2, 'رضا کریمی', 3200000, 'overdue'),
(1, 'سارا حسینی', 950000, 'pending');