CREATE DATABASE IF NOT EXISTS medical_store
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE medical_store;

-- User accounts used by the login form.
CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(190) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'customer') NOT NULL DEFAULT 'customer',
    created DATETIME NULL,
    modified DATETIME NULL
) ENGINE=InnoDB;

-- Categories table
CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT NULL,
    image VARCHAR(255) NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created DATETIME NULL,
    modified DATETIME NULL
);

-- Products table
CREATE TABLE products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NULL,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    description TEXT NULL,
    price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    stock INT UNSIGNED NOT NULL DEFAULT 0,
    image VARCHAR(255) NULL,
    is_featured TINYINT(1) NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created DATETIME NULL,
    modified DATETIME NULL,

    CONSTRAINT fk_products_categories
        FOREIGN KEY (category_id)
        REFERENCES categories(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

-- Sample categories
INSERT INTO categories (name, description)
VALUES
('Vitamins', 'Vitamins and supplements'),
('Personal Care', 'Personal care products'),
('Medical Devices', 'Medical and health devices');

-- Sample products
INSERT INTO products
(category_id, name, slug, description, price, stock, is_featured)
VALUES
(1, 'Vitamin B12', 'vitamin-b12',
 'Vitamin B12 product', 190.00, 25, 1),
(2, 'Skin Care Product', 'skin-care-product',
 'Personal care product', 150.00, 15, 1),
(3, 'Digital Thermometer', 'digital-thermometer',
 'Digital thermometer', 250.00, 10, 0);
