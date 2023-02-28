-- mysql -u username -p password -h localhost mydatabase -e "SELECT * FROM mytable"
-- Dans cette commande, 
-- remplacez "username" par le nom d'utilisateur de votre base de données, 
-- "password" par votre mot de passe, 
-- "mydatabase" par le nom de votre base de données
-- et "mytable" par le nom de la table que vous souhaitez afficher.

-- CREATE DATABASE db_quai

-- CREATE TABLE `categories` (
--   `id` int(11) NOT NULL AUTO_INCREMENT,
--   `name` varchar(150) NOT NULL,
--   PRIMARY KEY (`id`)
-- ) 

-- CREATE TABLE `products` (
--   `product_id` int(11) NOT NULL AUTO_INCREMENT,
--   `title` varchar(150) NOT NULL,
--   `content` text NOT NULL DEFAULT '',
--   `category_id` int(11) NOT NULL,
--   `prix` decimal(10,0) NOT NULL,
--   `product_image` varchar(250) DEFAULT NULL,
--   PRIMARY KEY (`product_id`),
--   FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
-- ) 

-- INSERT INTO `categories` (`name`) VALUES
-- ('Entrées'),
-- ('Plats'),
-- ('Desserts');

-- INSERT INTO products (title, content, category_id, prix)
-- VALUES
--     (
--         'Velouté de courge et crème de châtaigne',
--         'Velouté de courge, accompagné d\'une crème de châtaigne maison. Servi avec des croûtons à l\'ail et des noisettes concassées.',
--         1,
--         14.50
--     ),
--     (
--         'Salade savoyarde aux endives et au bleu',
--         'Mélange frais et croquant d\'endives, noix, lardons fumés et morceaux de fromage bleu, servie avec une vinaigrette à la moutarde et aux noix. ',
--         1,
--         12.50
--     ),
-- (
--         'Assiette de Gor ion',
--         'Viande séchée de boeuf charolais, spécialité du chef',
--         1,
--         '12'
--     ),
--     (
--         'Terrine artisanale',
--         'Pain de campagne toasté et condiments',
--         1,
--         '11.50'
--     );

-- INSERT INTO products (title, content, category_id, prix)
-- VALUES
-- (
-- 'Fondue savoyarde',
-- 'Fondue traditionnelle savoyarde à base de fromage Comté et Emmental, accompagnée de pain de seigle grillé et de pommes de terre.',
-- 2,
-- 22.50
-- ),
-- (
-- 'Tartiflette',
-- 'Tartiflette traditionnelle faite maison, avec des pommes de terre, oignons, lardons et fromage Reblochon.',
-- 2,
-- 21.00
-- ),
-- (
-- 'Raclette',
-- 'Raclette traditionnelle savoyarde, accompagnée de pommes de terre, charcuterie et cornichons.',
-- 2,
-- 24.50
-- ),
-- (
-- 'Croziflette',
-- 'Croziflette, une variante de la tartiflette, avec des crozets à la place des pommes de terre, accompagnée de lardons et de fromage Reblochon.',
-- 2,
-- 21.00
-- );



-- INSERT INTO products (title, content, category_id, prix)
-- VALUES
--     (
--         'Tarte aux myrtilles',
--         'Tarte aux myrtilles fraîches et crème glacée à la vanille.',
--         3,
--         12.50
--     ),
--     (
--         'Crème brûlée à la truffe',
--         'Crème brûlée classique relevée par une touche de truffe fraîche.',
--         3,
--         14.00
--     ),
--     (
--         'Fondant au chocolat',
--         'Fondant chaud et moelleux accompagné d\'une boule de glace à la vanille.',
--         3,
--         13.50
--     ),
--     (
--         'Tarte Tatin',
--         'Tarte aux pommes caramélisées, servie tiède avec de la crème glacée à la vanille.',
--         3,
--         12.00
--     );


-- CREATE TABLE gallerys (
--     gallery_id INT PRIMARY KEY,
--     gallery_title VARCHAR(255),
--     gallery_content VARCHAR(255),
--     gallery_img VARCHAR(255)
-- );

-- INSERT INTO gallerys ( gallery_title, gallery_content)
-- VALUES

--     (
--         'Fondant au bon chocolat',
--         'Fondant chaud et moelleux accompagné d\'une boule de glace à la vanille.'
--     ),
--     (
--         'Tarte la Tatin',
--         'Tarte aux pommes caramélisées, servie tiède avec de la crème glacée à la vanille.'
--     );


-- CREATE TABLE clients (
-- client_id INT(11) NOT NULL AUTO_INCREMENT,
-- username VARCHAR(255) NOT NULL,
-- email VARCHAR(255) NOT NULL,
-- password VARCHAR(255) NOT NULL,
-- statut ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
-- created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
-- updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
-- token VARCHAR(255) NULL,
-- PRIMARY KEY (client_id),
-- UNIQUE (username),
-- UNIQUE (email)
-- );


-- INSERT INTO clients (username, email, password, statut,created_at)
-- VALUES ('JohnDoe', 'johndoe@example.com', '$2y$10$pJLxJxH/pT.jg8bv3f3cX.b4s4sWYV8vEaPqy7xzGwT3O8aL3q3X2', 'active',NOW());

-- CREATE TABLE reservations (
-- reservation_id INT(11) NOT NULL AUTO_INCREMENT,
-- client_id INT(11) NOT NULL,
-- date DATE NOT NULL,
-- time TIME NOT NULL,
-- number_of_people INT(11) NOT NULL,
-- comments TEXT,
-- created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
-- PRIMARY KEY (reservation_id),
-- FOREIGN KEY (client_id) REFERENCES clients(client_id)
-- );

-- INSERT INTO reservations (client_id, date, time, number_of_people, comments)
-- VALUES (1, '2022-02-06', '19:00:00', 4, 'Fête d\'anniversaire');


-- CREATE TABLE opening_hours (
--     id INT PRIMARY KEY,
--     day_of_week VARCHAR(20),
--     lunch_opening_time TIME,
--     lunch_closing_time TIME,
--     dinner_opening_time TIME,
--     dinner_closing_time TIME
-- );


