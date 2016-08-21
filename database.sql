DROP DATABASE IF EXISTS silex;
CREATE DATABASE silex;
USE silex;

CREATE TABLE sessions (
    session_id VARCHAR(255),
    session_value TEXT,
    session_lifetime INTEGER UNSIGNED,
    session_time INTEGER UNSIGNED
) DEFAULT CHARSET=utf8;

CREATE TABLE users (
    id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(50),
    email VARCHAR(100),
    password VARCHAR(100),
    roles VARCHAR(100),
    is_active TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY username (username),
    UNIQUE KEY username_email (username, email)
) DEFAULT CHARSET=utf8;

CREATE TABLE people (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(50),
    address VARCHAR(255),
    PRIMARY KEY (id)
) DEFAULT CHARSET=utf8;

INSERT INTO users (username, email, password, roles, is_active) VALUES
('admin', 'admin@silex.local', '$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC', 'ROLE_ADMIN', 1),
('foo', 'foo@silex.local', '$2y$10$3i9/lVd8UOFIJ6PAMFt8gu3/r5g0qeCJvoSlLCsvMTythye19F77a', 'ROLE_USER', 0);

INSERT INTO people (name, address) VALUES
('Travis King','52926 Harvey Shore Apt. 190 Hicklemouth, MS 82405'),
('Leanna Kassulke','7960 Marion Haven Port Connerborough, ND 54003-3364'),
('Trystan Watsica','8810 Jettie Squares Apt. 605 Lake Martineville, MI 56935-0301'),
('Prof. Troy Mann II','167 Tyrese Square Apt. 410 Lillaberg, AZ 96265'),
('Onie Leuschke','7687 Kertzmann Parkway Apt. 523 South Jamisonstad, MT 09139'),
('Deontae Brekke','8402 Fahey Crest Gaymouth, TN 07717'),
('Mrs. Elvera Miller','6961 Balistreri Parkways Suite 405 Cassandrahaven, DC 34950-3717'),
('Prof. Arlo Schinner Jr.','55229 Grant Station Apt. 580 Mooreborough, NY 99119-4622'),
('Marge Klein V','345 DuBuque Rue South Milan, NY 99595'),
('Gust Aufderhar','126 Damaris Track Port Magdalenville, MO 13258-4668');
