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

INSERT INTO genero (id_genero, genero) VALUES ('M', 'Masculino');



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



