use Trabajo3;

create table usuario(
    idUsuario int NOT NULL AUTO_INCREMENT, 
    nombre varchar(30) NOT NULL,
    email varchar(100) NOT NULL,
    pass varchar(18) NOT NULL,
    isAdmin BOOLEAN NOT NULL,
    primary key (idUsuario)
);

create table producto(
    idProducto int NOT NULL AUTO_INCREMENT,
    nombre varchar(50) NOT NULL,
    precio decimal(6,2),
    stock int NOT NULL,
    descripcion varchar(200) NOT NULL,
    primary key (idProducto)
);

create table compra(
    idCompra int AUTO_INCREMENT NOT NULL,
    idUsuario int NOT NULL,
    precioTotal int NOT NULL,
    primary key(idCompra),
    foreign key(idUsuario) references usuario(idUsuario)
);

/*Datos de usuarios*/
INSERT INTO usuario (nombre, email, pass, isAdmin) VALUES
('Javier', 'javier@example.com', 'pass1234', 1),
('Álvaro', 'alvaro@example.com', 'pass1234', 1),
('Cristina', 'cristina@example.com', 'pass1234', 1),
('Jorge', 'jorge@example.com', 'pass1234', 1),
('Dani', 'dani@example.com', 'pass1234', 1),
('Laura', 'laura@example.com', 'pass1234', 0),
('Pedro', 'pedro@example.com', 'pass1234', 0),
('Sofía', 'sofia@example.com', 'pass1234', 0),
('Luis', 'luis@example.com', 'pass1234', 0),
('María', 'maria@example.com', 'pass1234', 0);
/*Datos de productos*/
INSERT INTO producto (nombre, precio, stock, descripcion) VALUES
('Laptop Gamer XYZ', 1200.00, 15, 'Laptop de alto rendimiento para juegos con tarjeta gráfica dedicada.'),
('Teclado Mecánico RGB', 75.50, 30, 'Teclado mecánico con retroiluminación RGB y switches mecánicos.'),
('Ratón Inalámbrico Ergonomico', 45.99, 25, 'Ratón inalámbrico con diseño ergonómico y batería de larga duración.'),
('Monitor 24" Full HD', 199.99, 10, 'Monitor de 24 pulgadas con resolución Full HD y panel IPS.'),
('Auriculares Gaming', 60.00, 20, 'Auriculares con sonido envolvente y micrófono ajustable.'),
('SSD 1TB', 120.00, 18, 'Disco duro sólido de 1TB para un rendimiento rápido y eficiente.'),
('Placa Base ATX', 150.00, 12, 'Placa base ATX compatible con procesadores Intel y AMD.'),
('Fuente de Poder 600W', 80.00, 22, 'Fuente de poder de 600W con certificación 80 Plus.'),
('Webcam HD 1080p', 40.00, 35, 'Cámara web HD 1080p ideal para videoconferencias.'),
('Cable HDMI 2.0', 15.00, 50, 'Cable HDMI 2.0 de alta velocidad para transmisión de video y audio.');
/*Datos de compras*/
INSERT INTO compra (idUsuario, precioTotal) VALUES
(1, 150),
(2, 200),
(3, 75),
(4, 300),
(5, 120),
(6, 250),
(7, 90),
(8, 400),
(9, 60),
(10, 180);