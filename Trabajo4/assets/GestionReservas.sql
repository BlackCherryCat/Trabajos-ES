CREATE DATABASE GestionReservas;
USE GestionReservas;

CREATE TABLE Cursos (
    IdCurso INT AUTO_INCREMENT,
    Nombre VARCHAR(50) NOT NULL,
    NumAlumnos INT NOT NULL CHECK (NumAlumnos >= 0),
    PRIMARY KEY (IdCurso)
);

CREATE TABLE Asignaturas (
    IdAsignatura INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(50) NOT NULL
);

CREATE TABLE Curso_Asignatura (
    IdCurso INT,
    IdAsignatura INT,
    PRIMARY KEY (IdCurso, IdAsignatura),
    FOREIGN KEY (IdCurso) REFERENCES Cursos(IdCurso) ON DELETE CASCADE,
    FOREIGN KEY (IdAsignatura) REFERENCES Asignaturas(IdAsignatura) ON DELETE CASCADE
);

CREATE TABLE Profesores (
    IdProfesor INT AUTO_INCREMENT,
    Nombre VARCHAR(50) NOT NULL,
    Apellidos VARCHAR(50) NOT NULL,
    Email VARCHAR(50) UNIQUE NOT NULL,
    Passwd VARCHAR(255) NOT NULL,
    EsAdmin BOOLEAN NOT NULL DEFAULT FALSE,
    EsAlta BOOLEAN NOT NULL DEFAULT TRUE,
    ImgPerfilURL VARCHAR(255),
    PRIMARY KEY (IdProfesor)
);

CREATE TABLE Profesor_Curso_Asignatura (
    IdCurso INT,
    IdAsignatura INT,
    IdProfesor INT,
    PRIMARY KEY (IdCurso, IdAsignatura, IdProfesor),
    FOREIGN KEY (IdCurso, IdAsignatura) REFERENCES Curso_Asignatura(IdCurso, IdAsignatura) ON DELETE CASCADE,
    FOREIGN KEY (IdProfesor) REFERENCES Profesores(IdProfesor) ON DELETE CASCADE
);

CREATE TABLE Reservas (
    IdReserva INT AUTO_INCREMENT,
    Fecha DATE NOT NULL,
    NumAlumnos INT NOT NULL CHECK (NumAlumnos > 0),
    IdCurso INT NOT NULL,
    IdAsignatura INT NOT NULL,
    IdProfesor INT NOT NULL,
    PRIMARY KEY (IdReserva),
    FOREIGN KEY (IdCurso, IdAsignatura, IdProfesor) REFERENCES Profesor_Curso_Asignatura(IdCurso, IdAsignatura, IdProfesor) ON DELETE CASCADE
);

CREATE TABLE Tramos (
    IdTramo INT AUTO_INCREMENT,
    Horario VARCHAR(50) NOT NULL,
    PRIMARY KEY (IdTramo)
);

CREATE TABLE Reserva_Tramos (
    IdReserva INT,
    IdTramo INT,
    PRIMARY KEY (IdReserva, IdTramo),
    FOREIGN KEY (IdReserva) REFERENCES Reservas(IdReserva) ON DELETE CASCADE,
    FOREIGN KEY (IdTramo) REFERENCES Tramos(IdTramo) ON DELETE CASCADE
);

CREATE TABLE Departamentos (
    IdDepartamento INT AUTO_INCREMENT,
    Nombre VARCHAR(50) NOT NULL,
    PRIMARY KEY (IdDepartamento)
);

CREATE TABLE Departamento_Asignatura (
    IdDepartamento INT NOT NULL,
    IdAsignatura INT NOT NULL,
    PRIMARY KEY (IdDepartamento, IdAsignatura),
    FOREIGN KEY (IdDepartamento) REFERENCES Departamentos(IdDepartamento) ON DELETE CASCADE,
    FOREIGN KEY (IdAsignatura) REFERENCES Asignaturas(IdAsignatura) ON DELETE CASCADE
);

-- Insertar datos
INSERT INTO Cursos (Nombre, NumAlumnos) VALUES
('1ºA ESO', 30),
('1ºB ESO', 28),
('2ºA ESO', 29),
('2ºB ESO', 27),
('3ºA ESO', 30),
('3ºB ESO', 28),
('4ºA ESO', 29),
('4ºB ESO', 27),
('1ºA Bachillerato', 25),
('1ºB Bachillerato', 24),
('2ºA Bachillerato', 23),
('2ºB Bachillerato', 22);

INSERT INTO Asignaturas (Nombre) VALUES
('Matemáticas'),
('Lengua y Literatura'),
('Historia'),
('Física y Química'),
('Biología'),
('Inglés');

INSERT INTO Curso_Asignatura (IdCurso, IdAsignatura) VALUES
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6),
(2, 1), (2, 2), (2, 3), (2, 4), (2, 5), (2, 6),
(3, 1), (3, 2), (3, 3), (3, 4), (3, 5), (3, 6),
(4, 1), (4, 2), (4, 3), (4, 4), (4, 5), (4, 6),
(5, 1), (5, 2), (5, 3), (5, 4), (5, 5), (5, 6),
(6, 1), (6, 2), (6, 3), (6, 4), (6, 5), (6, 6),
(7, 1), (7, 2), (7, 3), (7, 4), (7, 5), (7, 6),
(8, 1), (8, 2), (8, 3), (8, 4), (8, 5), (8, 6),
(9, 1), (9, 2), (9, 3), (9, 4), (9, 5), (9, 6),
(10, 1), (10, 2), (10, 3), (10, 4), (10, 5), (10, 6),
(11, 1), (11, 2), (11, 3), (11, 4), (11, 5), (11, 6),
(12, 1), (12, 2), (12, 3), (12, 4), (12, 5), (12, 6);




INSERT INTO Profesores (Nombre, Apellidos, Email, Passwd, EsAdmin, EsAlta, ImgPerfilURL) VALUES
('Noemí', 'Salobreña', 'noemi@gmail.com', '$2y$10$ays7ZVmdw9qWXM3zVJJzeedt/jk.c12NAS4MluY1Zi/V4Y4UKYGpG', TRUE, TRUE, './assets/img/perfiles/usuario.avif'),
('Javier', 'Villena', 'javier@gmail.com', '$2y$10$ays7ZVmdw9qWXM3zVJJzeedt/jk.c12NAS4MluY1Zi/V4Y4UKYGpG', FALSE, TRUE, './assets/img/perfiles/usuario.avif'),
('Cristina', 'Vacas', 'cristina@gmail.com', '$2y$10$ays7ZVmdw9qWXM3zVJJzeedt/jk.c12NAS4MluY1Zi/V4Y4UKYGpG', FALSE, TRUE, './assets/img/perfiles/usuario.avif'),
('Álvaro', 'De Quinta', 'alvaro@gmail.com', '$2y$10$ays7ZVmdw9qWXM3zVJJzeedt/jk.c12NAS4MluY1Zi/V4Y4UKYGpG', FALSE, TRUE, './assets/img/perfiles/usuario.avif'),
('Jorge', 'Segovia', 'jorge@gmail.com', '$2y$10$ays7ZVmdw9qWXM3zVJJzeedt/jk.c12NAS4MluY1Zi/V4Y4UKYGpG', FALSE, TRUE, './assets/img/perfiles/usuario.avif'),
('Francisco Daniel', 'López', 'franciscodaniel@gmail.com', '$2y$10$ays7ZVmdw9qWXM3zVJJzeedt/jk.c12NAS4MluY1Zi/V4Y4UKYGpG', FALSE, TRUE, './assets/img/perfiles/usuario.avif'),
('Daniel', 'Godoy', 'daniel@gmail.com', '$2y$10$ays7ZVmdw9qWXM3zVJJzeedt/jk.c12NAS4MluY1Zi/V4Y4UKYGpG', FALSE, TRUE, './assets/img/perfiles/usuario.avif'),
('Rafa', 'Díaz', 'rafa@gmail.com', '$2y$10$ays7ZVmdw9qWXM3zVJJzeedt/jk.c12NAS4MluY1Zi/V4Y4UKYGpG', FALSE, TRUE, './assets/img/perfiles/usuario.avif'),
('David', 'Villena', 'david@gmail.com', '$2y$10$ays7ZVmdw9qWXM3zVJJzeedt/jk.c12NAS4MluY1Zi/V4Y4UKYGpG', FALSE, TRUE, './assets/img/perfiles/usuario.avif'),
('Adrián', 'Jiménez', 'adrian@gmail.com', '$2y$10$ays7ZVmdw9qWXM3zVJJzeedt/jk.c12NAS4MluY1Zi/V4Y4UKYGpG', FALSE, TRUE, './assets/img/perfiles/usuario.avif'),
('Iván', 'Iván', 'ivan@gmail.com', '$2y$10$ays7ZVmdw9qWXM3zVJJzeedt/jk.c12NAS4MluY1Zi/V4Y4UKYGpG', FALSE, TRUE, './assets/img/perfiles/usuario.avif'),
('Pablo', 'Torres', 'pablo@gmail.com', '$2y$10$ays7ZVmdw9qWXM3zVJJzeedt/jk.c12NAS4MluY1Zi/V4Y4UKYGpG', FALSE, TRUE, './assets/img/perfiles/usuario.avif'),
('Juan Jesús', 'Revilla', 'juanjesus@gmail.com', '$2y$10$ays7ZVmdw9qWXM3zVJJzeedt/jk.c12NAS4MluY1Zi/V4Y4UKYGpG', FALSE, TRUE, './assets/img/perfiles/usuario.avif'),
('Dani', 'Pascual', 'danipascual@gmail.com', '$2y$10$ays7ZVmdw9qWXM3zVJJzeedt/jk.c12NAS4MluY1Zi/V4Y4UKYGpG', FALSE, FALSE, './assets/img/perfiles/usuario.avif'),
('Andrés', 'Bonilla', 'Andres@gmail.com', '$2y$10$ays7ZVmdw9qWXM3zVJJzeedt/jk.c12NAS4MluY1Zi/V4Y4UKYGpG', FALSE, True, './assets/img/perfiles/usuario.avif');

INSERT INTO Profesor_Curso_Asignatura (IdCurso, IdAsignatura, IdProfesor) VALUES
(9, 1, 1), (9, 2, 1), (9, 3, 1), (10, 4, 1), (10, 5, 1), (10, 6, 1),
(1, 1, 2), (1, 2, 2), (2, 3, 2), (2, 4, 2), (3, 5, 2), (3, 6, 2),
(4, 1, 3), (4, 2, 3), (5, 3, 3), (5, 4, 3), (6, 5, 3), (6, 6, 3),
(7, 1, 4), (7, 2, 4), (8, 3, 4), (8, 4, 4), (9, 5, 4), (9, 6, 4),
(10, 1, 5), (10, 2, 5), (11, 3, 5), (11, 4, 5), (12, 5, 5), (12, 6, 5),
(1, 1, 6), (1, 3, 6), (2, 2, 6), (2, 4, 6), (3, 5, 6), (3, 6, 6),
(4, 1, 7), (4, 2, 7), (5, 3, 7), (5, 4, 7), (6, 5, 7), (6, 6, 7),
(7, 1, 8), (7, 2, 8), (8, 3, 8), (8, 4, 8), (9, 5, 8), (9, 6, 8),
(10, 1, 9), (10, 2, 9), (11, 3, 9), (11, 4, 9), (12, 5, 9), (12, 6, 9),
(1, 1, 10), (1, 2, 10), (2, 3, 10), (2, 4, 10), (3, 5, 10), (3, 6, 10),
(4, 1, 11), (4, 2, 11), (5, 3, 11), (5, 4, 11), (6, 5, 11), (6, 6, 11),
(7, 1, 12), (7, 2, 12), (8, 3, 12), (8, 4, 12), (9, 5, 12), (9, 6, 12),
(10, 1, 13), (10, 2, 13), (11, 3, 13), (11, 4, 13), (12, 5, 13), (12, 6, 13);


INSERT INTO Tramos (Horario) VALUES
('08:00-09:00'),
('09:00-10:00'),
('10:00-11:00'),
('11:00-12:00'),
('12:00-13:00'),
('13:00-14:00');

INSERT INTO Departamentos (Nombre) VALUES
('Matemáticas'),
('Lengua y Literatura'),
('Ciencias Sociales'),
('Ciencias Naturales'),
('Idiomas');

INSERT INTO Departamento_Asignatura (IdDepartamento, IdAsignatura) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(4, 5),
(5, 6);

INSERT INTO Reservas (Fecha, NumAlumnos, IdCurso, IdAsignatura, IdProfesor) VALUES
('2025-03-15', 30, 9, 1, 1),
('2025-03-16', 28, 9, 2, 1),
('2025-03-17', 29, 9, 3, 1),
('2025-03-10', 100, 3, 5, 2);


INSERT INTO Reserva_Tramos (IdReserva, IdTramo) VALUES
(1, 1),
(2, 2),
(3, 3),
(4,1),
(4,2),
(4,3),
(4,4),
(4,5),
(4,6);