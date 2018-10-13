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
    fecha_receta DATE NOT NULL,
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
    CONSTRAINT FK_ID_TRATAMIENTO FOREIGN KEY (id_tratamiento) REFERENCES tratamientos(id_tratamiento),
    CONSTRAINT FK_CEDULA_PACIENTE FOREIGN KEY (cedula) REFERENCES paciente(cedula),
    CONSTRAINT CK_ID_TRATAMIENTO_X_CEDULA PRIMARY KEY (id_tratamiento, cedula)
);


/* INSERCION DE DATOS NECESARIOS */

-- generos
INSERT INTO genero (id_genero, genero) VALUES ('M', 'Masculino');
INSERT INTO genero (id_genero, genero) VALUES ('F', 'Femenino');

-- tipo de sangre
INSERT INTO tipo_sangre (id_tipo, tipo) VALUES (1, 'O negativo');
INSERT INTO tipo_sangre (id_tipo, tipo) VALUES (2, 'O positivo');

select * from paciente;

/* PROCEDIMIENTOS ALMACENADOS */
CREATE OR REPLACE PROCEDURE agregar_paciente(
    cedula IN VARCHAR2,
    nombre IN VARCHAR2,
    apellido1 IN VARCHAR2,
    apellido2 IN VARCHAR2,
    telefono IN VARCHAR2,
    fecha_nacimiento IN VARCHAR2,
    correo_electronico IN VARCHAR2,
    telefono_sos IN VARCHAR2,
    id_tipo_sangre IN NUMBER,
    id_genero IN VARCHAR2,
    peso IN NUMBER,
    altura IN NUMBER)
IS
-- declarar variables
total NUMBER;
BEGIN
    -- revisar si ya existe alguien con esa cedula
    total := 0;
    SELECT COUNT(*) INTO total FROM paciente WHERE cedula = cedula;
    
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
        VALUES (cedula,
                nombre,
                apellido1,
                apellido2,
                telefono,
                TO_DATE(fecha_nacimiento, 'DD-MM-YYYY'),
                correo_electronico,
                telefono_sos,
                id_tipo_sangre,
                id_genero,
                peso,
                altura);
    END IF;
END;






