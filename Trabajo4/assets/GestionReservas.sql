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
(1, 1), (1, 2), (1, 3),
(2, 1), (2, 2), (2, 3),
(3, 1), (3, 2), (3, 4),
(4, 1), (4, 2), (4, 4),
(5, 1), (5, 3), (5, 5),
(6, 1), (6, 3), (6, 5),
(7, 2), (7, 4), (7, 6),
(8, 2), (8, 4), (8, 6),
(9, 1), (9, 3), (9, 5),
(10, 1), (10, 3), (10, 5),
(11, 2), (11, 4), (11, 6),
(12, 2), (12, 4), (12, 6);

INSERT INTO Profesores (Nombre, Apellidos, Email, Passwd, EsAdmin, EsAlta, ImgPerfilURL) VALUES
('Cristina', 'Vacas', 'cvaclop1911@g.educaand.es', '$2y$10$ays7ZVmdw9qWXM3zVJJzeedt/jk.c12NAS4MluY1Zi/V4Y4UKYGpG', TRUE, TRUE, './assets/img/perfiles/usuario.avif'),
('Administrador', 'Reservas', 'noemi@g.educaand.es', '$2y$10$ays7ZVmdw9qWXM3zVJJzeedt/jk.c12NAS4MluY1Zi/V4Y4UKYGpG', TRUE, TRUE, './assets/img/perfiles/usuario.avif'),
('Carlos', 'López', 'carlos@gmail.com', '$2y$10$ays7ZVmdw9qWXM3zVJJzeedt/jk.c12NAS4MluY1Zi/V4Y4UKYGpG', FALSE, TRUE, './assets/img/perfiles/usuario.avif');

INSERT INTO Profesor_Curso_Asignatura (IdCurso, IdAsignatura, IdProfesor) VALUES
(1, 1, 1), (2, 1, 1),
(3, 2, 2), (4, 2, 2),
(5, 3, 3), (6, 3, 3);

INSERT INTO Tramos (Horario) VALUES
('08:00 - 09:00'),
('09:00 - 10:00'),
('10:00 - 11:00'),
('11:00 - 12:00'),
('12:00 - 13:00'),
('13:00 - 14:00');

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
('2025-03-15', 30, 1, 1, 1),
('2025-03-16', 28, 3, 2, 2),
('2025-03-17', 29, 5, 3, 3);

INSERT INTO Reserva_Tramos (IdReserva, IdTramo) VALUES
(1, 1),
(2, 2),
(3, 3);
