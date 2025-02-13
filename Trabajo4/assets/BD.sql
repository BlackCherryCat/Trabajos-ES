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
    FechaAlta DATE NOT NULL DEFAULT CURRENT_DATE,
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

