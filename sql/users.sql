CREATE TABLE users (
    id int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstname varchar(255) NOT NULL,
    lastname varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    google_id varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
    password varchar(255) NOT NULL,
    profile_image text COLLATE utf8mb4_unicode_ci NOT NULL,
    urole varchar(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;