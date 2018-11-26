/* CREACION DE TABLAS */
CREATE TABLE genero(
    id_genero VARCHAR2(1) NOT NULL PRIMARY KEY,
    genero VARCHAR2(15) NOT NULL,
    CONSTRAINT CHK_ID_GENERO CHECK (REGEXP_LIKE(id_genero, '^[MF]')) 
);

CREATE TABLE tipo_sangre(
    id_tipo NUMBER NOT NULL PRIMARY KEY,
    tipo VARCHAR2(15) NOT NULL,
    CONSTRAINT UNIQUE_TIPO UNIQUE (tipo)
);

CREATE TABLE tratamientos(
    id_tratamiento NUMBER NOT NULL PRIMARY KEY,
    tratamiento VARCHAR2(30) NOT NULL,
    CONSTRAINT UNIQUE_TRATAMIENTO UNIQUE (tratamiento)
);

CREATE TABLE paciente(
    cedula VARCHAR2(12) NOT NULL PRIMARY KEY,
    nombre VARCHAR2(30) NOT NULL,
    apellido1 VARCHAR2(30) NOT NULL,
    apellido2 VARCHAR2(30) NOT NULL,
    telefono VARCHAR2(9) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    correo_electronico VARCHAR2(100) NOT NULL,
    telefono_sos VARCHAR2(9),
    id_tipo_sangre NUMBER NOT NULL,
    id_genero VARCHAR2(1) NOT NULL,
    peso NUMBER,
    altura NUMBER,
    CONSTRAINT CHK_CEDULA CHECK (REGEXP_LIKE(cedula, '^[0-1][1-7](-)[0-9]{4}(-)[0-9]{4}$')),
    CONSTRAINT CHK_TELEFONO CHECK (REGEXP_LIKE(telefono, '^[0-9]{4}(-)[0-9]{4}$')),
    CONSTRAINT CHK_CORREO CHECK (REGEXP_LIKE(correo_electronico, '^.+@[a-z]+(\.com)$')),
    CONSTRAINT CHK_TELEFONO_SOS CHECK (REGEXP_LIKE(telefono_sos, '^[0-9]{4}(-)[0-9]{4}')),
    CONSTRAINT FK_ID_TIPO_SANGRE FOREIGN KEY (id_tipo_sangre) REFERENCES tipo_sangre(id_tipo),
    CONSTRAINT FK_ID_GENERO FOREIGN KEY (id_genero) REFERENCES genero(id_genero)
);

CREATE TABLE paciente_x_tratamiento(
    id_tratamiento NUMBER NOT NULL,
    cedula VARCHAR2(12) NOT NULL,
    fecha_receta DATE NOT NULL,
    CONSTRAINT FK_ID_TRATAMIENTO FOREIGN KEY (id_tratamiento) REFERENCES tratamientos(id_tratamiento),
    CONSTRAINT FK_CEDULA_PACIENTE FOREIGN KEY (cedula) REFERENCES paciente(cedula),
    CONSTRAINT CK_ID_TRATAMIENTO_X_CEDULA PRIMARY KEY (id_tratamiento, cedula)
);

CREATE TABLE departamento(
    id_departamento number not null primary key,
    departamento varchar2(30) not null
);

CREATE TABLE trabajo(
    id_trabajo number not null primary key,
    titulo_trabajo varchar2(30)
);

CREATE TABLE empleado(
    cedula VARCHAR2(12) NOT NULL PRIMARY KEY,
    nombre VARCHAR2(30) NOT NULL,
    apellido1 VARCHAR2(30) NOT NULL,
    apellido2 VARCHAR2(30) NOT NULL,
    telefono VARCHAR2(9) NOT NULL,
    correo_electronico VARCHAR2(100) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    id_departamento number not null,
    id_trabajo number not null,
    CONSTRAINT EHK_CEDULA CHECK (REGEXP_LIKE(cedula, '^[0-1][1-7](-)[0-9]{4}(-)[0-9]{4}$')),
    CONSTRAINT EHK_TELEFONO CHECK (REGEXP_LIKE(telefono, '^[0-9]{4}(-)[0-9]{4}$')),
    CONSTRAINT EHK_CORREO CHECK (REGEXP_LIKE(correo_electronico, '^.+@[a-z]+(\.com)$')),
    CONSTRAINT FK_ID_DEPARTAMENTO FOREIGN KEY (id_departamento) REFERENCES departamento(id_departamento),
    CONSTRAINT FK_ID_TRABAJO FOREIGN KEY (id_trabajo) REFERENCES trabajo(id_trabajo)
);



CREATE TABLE tipo_sala(
    id_tipo number not null primary key,
    tipo varchar2(30)
);

CREATE TABLE salas(
    num_salas number not null primary key,
    id_tipo number not null,
    constraint FK_ID_TIPO FOREIGN KEY(id_tipo)  REFERENCES tipo_sala(id_tipo) 
);

CREATE TABLE tipo_cita(
    id_tipo_cita number not null primary key,
    tipo_cita varchar2(30)
);

CREATE TABLE cita(
    id_cita number not null primary key,
    cedula_paciente varchar2(12) not null,
    cedula_empleado varchar2(12) not null,
    num_sala number not null,
    fecha_hora date not null,
    observaciones varchar2(200),
    id_tipo_cita number not null,
    FOREIGN KEY(cedula_paciente) REFERENCES paciente(cedula),
    FOREIGN KEY(cedula_empleado) REFERENCES empleado(cedula),
    FOREIGN KEY(num_sala) REFERENCES salas(num_salas),
    FOREIGN KEY(id_tipo_cita) references tipo_cita(id_tipo_cita)
);

/* SECUENCIAS DE AUTOINCREMENTO */
CREATE SEQUENCE tipo_sala_secuencia START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE num_salas_secuencia START WITH 1 INCREMENT BY 1;

/* INSERCION DE DATOS NECESARIOS */

-- departamentos
INSERT INTO departamento (id_departamento, departamento) VALUES (1, 'Admin');
INSERT INTO departamento (id_departamento, departamento) VALUES (2, 'Medicina');

-- trabajos
INSERT INTO trabajo (id_trabajo, titulo_trabajo) VALUES (1, 'Secretariado');
INSERT INTO trabajo (id_trabajo, titulo_trabajo) VALUES (2, 'Medico general');


-- generos
INSERT INTO genero (id_genero, genero) VALUES ('M', 'Masculino');
INSERT INTO genero (id_genero, genero) VALUES ('F', 'Femenino');

-- tipo de sangre
INSERT INTO tipo_sangre (id_tipo, tipo) VALUES (1, 'O negativo');
INSERT INTO tipo_sangre (id_tipo, tipo) VALUES (2, 'O positivo');

-- salas
INSERT INTO tipo_sala (id_tipo, tipo) VALUES (tipo_sala_secuencia.NEXTVAL, 'Consultorio');
INSERT INTO tipo_sala (id_tipo, tipo) VALUES (tipo_sala_secuencia.NEXTVAL, 'Partos');
INSERT INTO tipo_sala (id_tipo, tipo) VALUES (tipo_sala_secuencia.NEXTVAL, 'Almacen');
INSERT INTO tipo_sala (id_tipo, tipo) VALUES (tipo_sala_secuencia.NEXTVAL, 'Habitacion');
INSERT INTO tipo_sala (id_tipo, tipo) VALUES (tipo_sala_secuencia.NEXTVAL, 'Emergencias');

/* PROCEDIMIENTOS ALMACENADOS */

-- procedimiento almacenado para guardar un paciente
CREATE OR REPLACE PROCEDURE agregar_paciente(
    cedula_paciente IN VARCHAR2,
    nombre_paciente IN VARCHAR2,
    apellido1_paciente IN VARCHAR2,
    apellido2_paciente IN VARCHAR2,
    telefono_paciente IN VARCHAR2,
    fecha_nacimiento_paciente IN VARCHAR2,
    correo_electronico_paciente IN VARCHAR2,
    telefono_sos_paciente IN VARCHAR2,
    id_tipo_sangre_paciente IN NUMBER,
    id_genero_paciente IN VARCHAR2,
    peso_paciente IN NUMBER,
    altura_paciente IN NUMBER)
IS
    -- declarar variables
    total NUMBER;
BEGIN
    -- revisar si ya existe alguien con esa cedula
    total := 0;
    SELECT COUNT(*) INTO total FROM paciente WHERE cedula = cedula_paciente;
    
    -- si no, agregar a la persona
    IF total = 0 THEN
        INSERT INTO paciente(cedula,
                             nombre,
                             apellido1,
                             apellido2,
                             telefono,
                             fecha_nacimiento,
                             correo_electronico,
                             telefono_sos,
                             id_tipo_sangre,
                             id_genero,
                             peso,
                             altura)
        VALUES (cedula_paciente,
                nombre_paciente,
                apellido1_paciente,
                apellido2_paciente,
                telefono_paciente,
                TO_DATE(fecha_nacimiento_paciente, 'DD-MM-YYYY'),
                correo_electronico_paciente,
                telefono_sos_paciente,
                id_tipo_sangre_paciente,
                id_genero_paciente,
                peso_paciente,
                altura_paciente);
    END IF;
END;

-- procedimient almacenado para guardar un tratamiento
CREATE OR REPLACE PROCEDURE agregar_tratamiento(
    codigo IN NUMBER,
    descripcion IN VARCHAR2
)
IS
-- declarar variables
total NUMBER;
BEGIN
    -- revisar si ya existe tratamiento con ese codigo
    total := 0;
    SELECT COUNT(*) INTO total FROM tratamientos WHERE id_tratamiento = codigo;
    
    -- si no, agregarlo
    IF total = 0 THEN
        INSERT INTO tratamientos(id_tratamiento, tratamiento)
        VALUES (codigo, descripcion);
    END IF;
END;

-- procedimiento almacenado para guardar un empleado
CREATE OR REPLACE PROCEDURE agregar_empleado(
    cedula_empleado IN VARCHAR2,
    nombre_empleado IN VARCHAR2,
    apellido1_empleado IN VARCHAR2,
    apellido2_empleado IN VARCHAR2,
    telefono_empleado IN VARCHAR2,
    fecha_nacimiento_empleado IN VARCHAR2,
    correo_electronico_empleado IN VARCHAR2,
    id_departamento_empleado IN NUMBER,
    id_puesto_empleado IN NUMBER)
IS
-- declarar variables
total NUMBER;
BEGIN
    -- revisar si ya existe alguien con esa cedula
    total := 0;
    SELECT COUNT(*) INTO total FROM empleado WHERE cedula = cedula_empleado;
    
    -- si no, agregar al empleado
    IF total = 0 THEN
        INSERT INTO empleado(cedula,
                             nombre,
                             apellido1,
                             apellido2,
                             telefono,
                             fecha_nacimiento,
                             correo_electronico,
                             id_departamento,
                             id_trabajo)
        VALUES (cedula_empleado,
                nombre_empleado,
                apellido1_empleado,
                apellido2_empleado,
                telefono_empleado,
                TO_DATE(fecha_nacimiento_empleado, 'DD-MM-YYYY'),
                correo_electronico_empleado,
                id_departamento_empleado,
                id_puesto_empleado);
    END IF;
END;

CREATE OR REPLACE PROCEDURE agregar_sala(
    id_tipo_sala IN NUMBER)
IS
BEGIN
    INSERT INTO salas(num_salas, id_tipo) VALUES (num_salas_secuencia.NEXTVAL, id_tipo_sala);
END;



