CREATE DATABASE GestionReservas;
USE GestionReservas;

CREATE TABLE Cursos (
    IdCurso INT,
    Nombre VARCHAR(20),
    NumAlumnos INT,
    PRIMARY KEY (IdCurso)
);

CREATE TABLE Asignaturas (
    IdAsignatura INT PRIMARY KEY,
    Nombre VARCHAR(30)
);

CREATE TABLE Curso_Asignatura (
    IdCurso INT,
    IdAsignatura INT,
    PRIMARY KEY (IdCurso, IdAsignatura),
    FOREIGN KEY (IdCurso) REFERENCES Cursos(IdCurso),
    FOREIGN KEY (IdAsignatura) REFERENCES Asignaturas(IdAsignatura)
);

CREATE TABLE Profesores (
    IdProfesor INT,
    Nombre VARCHAR(30),
    Apellidos VARCHAR(50),
    Email VARCHAR(40) UNIQUE,
    Password VARCHAR(20),
    EsAdmin BOOLEAN,
    FechaAlta DATE,
    PRIMARY KEY (IdProfesor)
);

CREATE TABLE Profesor_Curso_Asignatura (
    IdCurso INT,
    IdAsignatura INT,
    IdProfesor INT,
    PRIMARY KEY (IdCurso, IdAsignatura, IdProfesor),
    FOREIGN KEY (IdCurso, IdAsignatura) REFERENCES Curso_Asignatura(IdCurso, IdAsignatura),
    FOREIGN KEY (IdProfesor) REFERENCES Profesores(IdProfesor)
);

CREATE TABLE Reservas (
    IdReserva INT,
    Fecha DATE,
    NumAlumnos INT,
    IdCurso INT,
    IdAsignatura INT,
    IdProfesor INT,
    PRIMARY KEY (IdReserva),
    FOREIGN KEY (IdCurso, IdAsignatura, IdProfesor) REFERENCES Profesor_Curso_Asignatura(IdCurso, IdAsignatura, IdProfesor)
);

CREATE TABLE Tramos (
    IdTramo INT ,
    Horario VARCHAR(50),
    PRIMARY KEY (IdTramo)
);

CREATE TABLE Reserva_Tramos (
    IdReserva INT,
    IdTramo INT,
    PRIMARY KEY (IdReserva, IdTramo),
    FOREIGN KEY (IdReserva) REFERENCES Reservas(IdReserva),
    FOREIGN KEY (IdTramo) REFERENCES Tramos(IdTramo)
);

CREATE TABLE Departamentos (
    IdDepartamento INT,
    IdAsignatura INT,
    Nombre VARCHAR(20),
    PRIMARY KEY (IdDepartamento),
    FOREIGN KEY (IdAsignatura) REFERENCES Asignaturas(IdAsignatura)
);
