-- Tạo bảng roles
CREATE TABLE roles (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       name VARCHAR(255) NOT NULL,
                       canonical VARCHAR(255) UNIQUE NOT NULL,
                       publish TINYINT(1) DEFAULT 1,
                       created_at DATE DEFAULT (CURRENT_DATE),
                       updated_at DATE DEFAULT (CURRENT_DATE),
                       admin_id INT DEFAULT NULL,
                       CONSTRAINT fk_roles_admins FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE SET NULL
);

-- Tạo bảng users
CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       user_id INT DEFAULT NULL,
                       name VARCHAR(255) NOT NULL,
                       image VARCHAR(255),
                       email VARCHAR(255) UNIQUE NOT NULL,
                       phone VARCHAR(255) DEFAULT NULL,
                       password VARCHAR(255) NOT NULL,
                       address VARCHAR(255) DEFAULT NULL,
                       bio VARCHAR(255) DEFAULT NULL,
                       birthday VARCHAR(255) DEFAULT NULL,
                       publish TINYINT(1) DEFAULT 1,
                       created_at DATE DEFAULT (CURRENT_DATE),
                       updated_at DATE DEFAULT (CURRENT_DATE),
                       INDEX idx_users_id (id),
                       INDEX idx_users_user_id (user_id),
                       INDEX idx_users_publish (publish)
);


ALTER TABLE users
DROP COLUMN user_id,
    MODIFY name VARCHAR(255) DEFAULT NULL,
    MODIFY image VARCHAR(255) DEFAULT NULL,
    MODIFY phone VARCHAR(255) DEFAULT NULL
-- Tạo bảng admins
CREATE TABLE admins (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        admin_id INT DEFAULT NULL,
                        role_id INT DEFAULT NULL,
                        name VARCHAR(255) NOT NULL,
                        email VARCHAR(255) DEFAULT NULL,
                        password VARCHAR(255) NOT NULL,
                        bio VARCHAR(255) DEFAULT NULL,
                        phone VARCHAR(255) DEFAULT NULL,
                        address VARCHAR(255) DEFAULT NULL,
                        image VARCHAR(255) DEFAULT NULL,
                        birthday VARCHAR(255) DEFAULT NULL,
                        publish TINYINT(1) DEFAULT 1,
                        created_at DATE DEFAULT (CURRENT_DATE),
                        updated_at DATE DEFAULT (CURRENT_DATE),
                        CONSTRAINT fk_admins_roles FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE SET NULL,
                        INDEX idx_admins_role_id (role_id),
                        INDEX idx_admins_admin_id (admin_id)
);

-- Tạo bảng permissions
CREATE TABLE permissions (
                             id INT AUTO_INCREMENT PRIMARY KEY,
                             name VARCHAR(255) NOT NULL,
                             module VARCHAR(255) NOT NULL,
                             value INT NOT NULL,
                             title VARCHAR(255) DEFAULT NULL,
                             description TEXT DEFAULT NULL,
                             publish INT DEFAULT 1,
                             admin_id INT DEFAULT NULL,
                             created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                             updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                             UNIQUE KEY unique_module_value (module, value),
                             INDEX idx_permissions_user_id (admin_id),
                             CONSTRAINT fk_permissions_users FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE SET NULL
);

-- Tạo bảng role_permission
CREATE TABLE role_permission (
                                 id INT AUTO_INCREMENT PRIMARY KEY,
                                 permission_id INT NOT NULL,
                                 role_id INT NOT NULL,
                                 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                 UNIQUE KEY unique_permission_role (permission_id, role_id),
                                 INDEX idx_rp_permission_id (permission_id),
                                 INDEX idx_rp_role_id (role_id),
                                 CONSTRAINT fk_rp_permission FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
                                 CONSTRAINT fk_rp_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

-- Tạo bảng post_catalogues
CREATE TABLE post_catalogues (
                                 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                 admin_id INT NULL,
                                 name VARCHAR(255) NULL,
                                 canonical VARCHAR(255) UNIQUE NOT NULL DEFAULT '',
                                 description TEXT NULL,
                                 meta_description LONGTEXT NULL,
                                 meta_keyword VARCHAR(255) NULL,
                                 meta_title VARCHAR(255) NULL,
                                 image VARCHAR(255) NULL,
                                 publish TINYINT(1) NOT NULL DEFAULT 1,
                                 `order` INT NOT NULL DEFAULT 0,
                                 lft INT NULL,
                                 rgt INT NULL,
                                 level INT NULL,
                                 parent_id INT NOT NULL DEFAULT 0,
                                 created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
                                 updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                 FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng posts
CREATE TABLE posts (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       admin_id INT NULL,
                       name VARCHAR(255) NULL,
                       canonical VARCHAR(255) UNIQUE NOT NULL DEFAULT '',
                       description TEXT NULL,
                       content LONGTEXT NULL,
                       meta_description LONGTEXT NULL,
                       meta_keyword VARCHAR(255) NULL,
                       meta_title VARCHAR(255) NULL,
                       image VARCHAR(255) NULL,
                       album LONGTEXT NULL,
                       publish TINYINT(1) DEFAULT 1,
                       `order` INT DEFAULT 0,
                       post_catalogue_id INT DEFAULT 0,
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                       CONSTRAINT fk_posts_admin FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE SET NULL
);
ALTER TABLE posts DROP COLUMN album;

-- Tạo bảng product_catalogues
CREATE TABLE product_catalogues (
                                 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                 admin_id INT NULL,
                                 name VARCHAR(255) NULL,
                                 canonical VARCHAR(255) UNIQUE NOT NULL DEFAULT '',
                                 description TEXT NULL,
                                 meta_description LONGTEXT NULL,
                                 meta_keyword VARCHAR(255) NULL,
                                 meta_title VARCHAR(255) NULL,
                                 image VARCHAR(255) NULL,
                                 publish TINYINT(1) NOT NULL DEFAULT 1,
                                 `order` INT NOT NULL DEFAULT 0,
                                 lft INT NULL,
                                 rgt INT NULL,
                                 level INT NULL,
                                 parent_id INT NOT NULL DEFAULT 0,
                                 created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
                                 updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                 FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE product_catalogues MODIFY COLUMN id INT AUTO_INCREMENT;

-- Tạo bảng unit_products
CREATE TABLE unit_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NULL,
    name VARCHAR(55) NOT NULL ,
    value VARCHAR(20) NOT NULL ,
    unit VARCHAR(10) NOT NULL ,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE SET NULL
)
ALTER TABLE unit_products ADD COLUMN publish TINYINT(1) NOT NULL DEFAULT 1;

-- Tạo bảng brand_products
CREATE TABLE brand_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NULL,
    name VARCHAR(255) NOT NULL ,
    description VARCHAR(255) NULL ,
    image VARCHAR(255) NULL ,
    publish TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE SET NULL
)

-- Tạo bảng products
CREATE TABLE products (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          admin_id INT NULL,
                          name VARCHAR(255) NULL,
                          canonical VARCHAR(255) UNIQUE NOT NULL DEFAULT '',
                          description TEXT NULL,
                          content LONGTEXT NULL,
                          meta_description LONGTEXT NULL,
                          meta_keyword VARCHAR(255) NULL,
                          meta_title VARCHAR(255) NULL,
                          image VARCHAR(255) NULL,
                          album LONGTEXT NULL,
                          publish TINYINT(1) DEFAULT 1,
                          `order` INT DEFAULT 0,
                          product_catalogue_id INT NULL,
                          brand_id INT NULL,
                          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                          updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                          CONSTRAINT fk_products_admin FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE SET NULL,
                          CONSTRAINT fk_products_catalogue FOREIGN KEY (product_catalogue_id) REFERENCES product_catalogues(id) ON DELETE SET NULL,
                          CONSTRAINT fk_brands_id FOREIGN KEY (brand_id) REFERENCES brand_products(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE products
    CHANGE COLUMN brand_id brand_product_id INT NULL;

ALTER TABLE products
    ADD COLUMN discount INT NULL AFTER brand_product_id,
    ADD COLUMN start_date DATE NULL AFTER discount,
    ADD COLUMN end_date DATE NULL AFTER start_date;


CREATE TABLE product_variants (
                                  id INT AUTO_INCREMENT PRIMARY KEY,
                                  product_id INT NOT NULL,
                                  unit_id INT NOT NULL,
                                  sku VARCHAR(50) UNIQUE NOT NULL,
                                  price VARCHAR(50) NOT NULL DEFAULT '0',
                                  stock INT NOT NULL DEFAULT 0,
                                  publish TINYINT(1) NOT NULL DEFAULT 1,
                                  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                  CONSTRAINT fk_variants_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
                                  CONSTRAINT fk_variants_unit FOREIGN KEY (unit_id) REFERENCES unit_products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE product_variants
    MODIFY sku VARCHAR(255) NOT NULL,
    MODIFY price VARCHAR(255) DEFAULT '0' NOT NULL;
ALTER TABLE product_variants
    MODIFY publish TINYINT(1) DEFAULT 1 NULL;

ALTER TABLE product_variants
    ADD COLUMN sold INT NOT NULL DEFAULT 0 AFTER stock;


CREATE TABLE verify_email (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL ,
    code varchar(6) NOT NULL ,
    expire_at INT NOT NULL ,
    dead_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
ALTER TABLE verify_email
    ADD COLUMN was_use TINYINT NULL AFTER dead_at;

CREATE TABLE carts (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       user_id INT NOT NULL,
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                       FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE cart_items (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            cart_id INT NOT NULL,  -- Liên kết với bảng giỏ hàng
                            product_id INT NOT NULL,  -- Liên kết với bảng sản phẩm
                            quantity INT NOT NULL,  -- Số lượng sản phẩm
                            unit VARCHAR(50) NOT NULL,  -- Số lượng sản phẩm
                            total_price INT NOT NULL,  -- Tổng giá trị của sản phẩm (quantity * price)
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            FOREIGN KEY (cart_id) REFERENCES carts(id),
                            FOREIGN KEY (product_id) REFERENCES products(id)
);
ALTER TABLE cart_items ADD UNIQUE KEY unique_cart_product_unit (cart_id, product_id, unit);
ALTER TABLE cart_items
    ADD COLUMN price INT NOT NULL AFTER unit;

ALTER TABLE cart_items
    ADD COLUMN product_variant_id INT AFTER cart_id,
    ADD CONSTRAINT fk_product_variant_id FOREIGN KEY (product_variant_id) REFERENCES product_variants(id);


-- Tạo bảng address-shopping

CREATE TABLE address_shoppings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NOT NULL,
    isDefault TINYINT(1) NOT NULL DEFAULT 2,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Tạo bảng vouchers
CREATE TABLE vouchers (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       admin_id INT NULL,
                       name VARCHAR(255) NULL,
                       description TEXT NULL,
                       value INT NOT NULL,
                       min INT NOT NULL,
                       max INT NOT NULL,
                       start_at TIMESTAMP,
                       dead_at TIMESTAMP,
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                       CONSTRAINT fk_posts_admin FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE SET NULL
);

ALTER TABLE vouchers ADD CONSTRAINT unique_voucher_name UNIQUE (name);
ALTER TABLE vouchers
    ADD COLUMN publish TINYINT(1) NOT NULL DEFAULT 1
AFTER max;

ALTER TABLE vouchers
    ADD COLUMN quantity INT NOT NULL
AFTER max;

CREATE TABLE status_orders (
                               id INT AUTO_INCREMENT PRIMARY KEY,
                               name VARCHAR(255) NULL,
                               value INT NOT NULL
)

INSERT INTO status_orders (name, value) VALUES
    ('Chờ xác nhận', 1),
    ('Đang xử lý', 2),
    ('Thành công', 3),
    ('Thất bại', 4);

CREATE TABLE orders (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        status_order_id INT DEFAULT 1,
                        total_price INT NOT NULL ,
                        payment_method VARCHAR(255) NOT NULL ,
                        description TEXT NULL ,
                        address_shopping_id INT NULL ,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        CONSTRAINT fk_status_orders FOREIGN KEY (status_order_id) REFERENCES status_orders(id) ON DELETE SET NULL,
                        CONSTRAINT fk_address_shopping FOREIGN KEY (address_shopping_id) REFERENCES address_shoppings(id) ON DELETE SET NULL
)

ALTER TABLE orders
    ADD COLUMN code VARCHAR(255) NOT NULL AFTER id;


ALTER TABLE orders
    ADD COLUMN user_id INT NULL AFTER id,
ADD CONSTRAINT fk_orders_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL;


CREATE TABLE order_detail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NULL ,
    quantity INT NOT NULL ,
    price INT NOT NULL ,
    sku VARCHAR(255) NOT NULL,
    CONSTRAINT fk_order_detail_product_id FOREIGN KEY (product_id) REFERENCES products(id)
)
    RENAME TABLE order_detail TO order_details;
ALTER TABLE order_details DROP COLUMN sku;

ALTER TABLE order_details
    CHANGE COLUMN product_id product_variant_id INT NULL;

ALTER TABLE order_details
DROP FOREIGN KEY fk_order_detail_product_id;
ALTER TABLE order_details
    ADD CONSTRAINT fk_order_detail_variant_id
        FOREIGN KEY (product_variant_id) REFERENCES product_variants(id)
            ON DELETE SET NULL;


CREATE TABLE product_ratings (
                                 id INT AUTO_INCREMENT PRIMARY KEY,
                                 user_id INT,
                                 product_id INT,
                                 customer_name VARCHAR(255),
                                 customer_email VARCHAR(255),
                                 customer_content TEXT,
                                 rating INT,
                                 created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                                 updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                 CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                                 CONSTRAINT fk_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

ALTER TABLE product_ratings
    ADD COLUMN rating_text VARCHAR(255) AFTER rating;
