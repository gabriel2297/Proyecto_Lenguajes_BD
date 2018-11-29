/* CREACION DE TABLAS */
CREATE TABLE genero(
    id_genero VARCHAR2(1) NOT NULL PRIMARY KEY,
    genero VARCHAR2(15) NOT NULL,
    CONSTRAINT CHK_ID_GENERO CHECK (REGEXP_LIKE(id_genero, '^[MF]')) 
);

CREATE TABLE tipo_sangre(
    sang_id_tipo NUMBER NOT NULL PRIMARY KEY,
    sang_tipo VARCHAR2(15) NOT NULL,
    CONSTRAINT UNIQUE_TIPO UNIQUE (sang_tipo)
);

CREATE TABLE tratamientos(
    id_tratamiento NUMBER NOT NULL PRIMARY KEY,
    tratamiento VARCHAR2(30) NOT NULL,
    fecha_receta DATE NOT NULL,
    CONSTRAINT UNIQUE_TRATAMIENTO UNIQUE (tratamiento)
);
create TABLE paciente(
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
INSERT INTO genero (id_genero, genero) VALUES ('F', 'Femenino');




CREATE TABLE departamento(
id_departamento number not null primary key,
departamento varchar2(30) not null
);

CREATE TABLE trabajo(
id_trabajo number not null primary key,
titulo_trabajo varchar2(30)
);


CREATE TABLE empleado(
    ecedula VARCHAR2(12) NOT NULL PRIMARY KEY,
    enombre VARCHAR2(30) NOT NULL,
    eapellido1 VARCHAR2(30) NOT NULL,
    eapellido2 VARCHAR2(30) NOT NULL,
    etelefono VARCHAR2(9) NOT NULL,
    ecorreo_electronico VARCHAR2(100) NOT NULL,
    efecha_nacimiento DATE NOT NULL,
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
 FOREIGN KEY(cedula_empleado) REFERENCES empleado(ecedula),
 FOREIGN KEY(num_sala) REFERENCES salas(num_salas),
 FOREIGN KEY(id_tipo_cita) references tipo_cita(id_tipo_cita)


);



/* INSERCION DE DATOS NECESARIOS */

-- generos
INSERT INTO genero (id_genero, genero) VALUES ('M', 'Masculino');
INSERT INTO genero (id_genero, genero) VALUES ('F', 'Femenino');

-- tipo de sangre
INSERT INTO tipo_sangre (id_tipo, tipo) VALUES (1, 'O negativo');
INSERT INTO tipo_sangre (id_tipo, tipo) VALUES (2, 'O positivo');

--departamentos
INSERT INTO departamento (id_departamento,departamento) VALUES (1, 'Dermatología');
INSERT INTO departamento (id_departamento,departamento) VALUES (2, 'Ginecología');
--trabajo
INSERT INTO trabajo (id_trabajo,titulo_trabajo) VALUES (1, 'Médico');
INSERT INTO trabajo (id_trabajo,titulo_trabajo) VALUES (2, 'Técnico');
INSERT INTO trabajo (id_trabajo,titulo_trabajo) VALUES (3, 'Asistente');

--Tipo sala
INSERT INTO tipo_sala (id_tipo, tipo) VALUES (200, 'Transplantes');
INSERT INTO tipo_sala (id_tipo, tipo) VALUES (201, 'Cirugía');
INSERT INTO tipo_sala (id_tipo, tipo) VALUES (202, 'Partos');

--Salas
INSERT INTO salas (num_salas, id_tipo) VALUES (1, 200);
INSERT INTO salas (num_salas, id_tipo) VALUES (2, 201);
INSERT INTO salas (num_salas, id_tipo) VALUES (3, 202);

--tipo_cita
INSERT INTO tipo_cita (id_tipo_cita, tipo_cita) VALUES (1, 'Consulta');
INSERT INTO tipo_cita (id_tipo_cita, tipo_cita) VALUES (2, 'Revision General');
INSERT INTO tipo_cita (id_tipo_cita, tipo_cita) VALUES (3, 'Seguimiento');

--







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
  VERROR NUMBER;
  VEXP exception;
VMES VARCHAR2(500);
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
    
   ELSE
   raise vexp;
    END IF;
    exception
    WHEN VEXP THEN
       VERROR := SQLCODE;
       VMES := 'El Paciente ya existe ';
       INSERT INTO AUDITORIA ( NERROR, MENSAJE, FECHA, USUARIO) 
             VALUES(VERROR,VMES,SYSDATE, USER);

  WHEN  OTHERS  THEN
       VERROR := SQLCODE;
       VMES := SQLERRM;
                     dbms_output.put_line(VMES);
       INSERT INTO AUDITORIA ( NERROR, MENSAJE, FECHA, USUARIO ) 
                   VALUES(VERROR,VMES,SYSDATE, USER);    
END;


execute agregar_paciente('11-0723-0822','Pepe','Rodriguez','Centeno','8401-9915','14/10/1998','Juan1958@hotmail.com','2262-7879',1,'M',65,175);

/*Tabla de Auditorias*/
CREATE TABLE AUDITORIA ( NERROR NUMBER,
MENSAJE  VARCHAR2(500), 
FECHA DATE ,
USUARIO VARCHAR2(50));







select * from auditoria


select * from genero

--Agregar empleado
CREATE OR REPLACE PROCEDURE agregar_empleado(
ecedula in varchar2,
enombre in VARCHAR2,
eapellido1 in varchar2,
eapellido2 in VARCHAR2,
etelefono VARCHAR2,
ecorreo_electronico in VARCHAR2,
efecha_nacimiento in varchar2,
id_departamento in number,
id_trabajo in number)
as
VERROR NUMBER;
VMES VARCHAR2(500);
total NUMBER;
VEXP exception;
begin
total := 0;
    SELECT COUNT(*) INTO total FROM empleado WHERE cedula = ecedula;
     IF total = 0 THEN
        INSERT INTO empleado(cedula,
                             nombre,
                             apellido1,
                             apellido2,
                             telefono,
                             correo_electronico,
                             fecha_nacimiento,
                             id_departamento,
                             id_trabajo)
        VALUES (ecedula,
                enombre,
                eapellido1,
                eapellido2,
                etelefono,
                ecorreo_electronico,
                TO_DATE(efecha_nacimiento, 'DD-MM-YYYY'),
                id_departamento,
                id_trabajo);
   ELSE
   raise VEXP;
    END IF;
    exception
    when VEXP then
    VERROR := SQLCODE;
       VMES := 'El empleado ya esta registrado en la base de datos';
                     dbms_output.put_line(VMES);
       INSERT INTO AUDITORIA ( NERROR, MENSAJE, FECHA, USUARIO ) 
                   VALUES(VERROR,VMES,SYSDATE, USER);   
  WHEN  OTHERS  THEN
       VERROR := SQLCODE;
       VMES := SQLERRM;
       INSERT INTO AUDITORIA ( NERROR, MENSAJE, FECHA, USUARIO ) 
                   VALUES(VERROR,VMES,SYSDATE, USER);    
END;


execute agregar_empleado('11-0743-0982','Andres','Escalante','Armadillo','7698-0232','Escalante.9874@gmail.com','19/07/1980',1,1)

/*Agregar cita*/
create or replace procedure crear_cita(vid_cita in number,
                                        cedulaP in varchar2,
                                        cedulaE in varchar2,
                                        numSala in number,
                                        fechaH in varchar2,
                                        observ in varchar2,
                                        idTipoCita in number )


as
 VERROR NUMBER;
  VEXP exception;
VMES VARCHAR2(500);
total NUMBER;
cont number;
BEGIN
    -- revisar si ya existe alguien con esa cedula
    total := 0;
    SELECT COUNT(*) INTO total FROM cita WHERE id_cita = vid_cita;
    SELECT COUNT(id_cita) INTO cont FROM cita ;

    -- si no, agregar a la persona
    IF total = 0 THEN
    cont:=cont+1;
        INSERT INTO cita(id_cita,
                             cedula_paciente,
                             cedula_empleado,
                             num_sala,
                             fecha_hora,
                             observaciones,
                             id_tipo_cita)
                             
        VALUES (cont,
                cedulaP,
                cedulaE,
                numSala,
                TO_DATE(fechah, 'DD-MM-YYYY'),
                observ,
                idTipoCita);
                
    
   ELSE
    raise  VEXP;
    END IF;
    exception
    WHEN VEXP THEN
              dbms_output.put_line(VMES);
       VERROR := SQLCODE;
       VMES := 'La cita ya existe en la base de datos ';
       INSERT INTO AUDITORIA ( NERROR, MENSAJE, FECHA, USUARIO) 
             VALUES(VERROR,VMES,SYSDATE, USER);

  WHEN  OTHERS  THEN
       VERROR := SQLCODE;
       VMES := SQLERRM;
                     dbms_output.put_line(VMES);
       INSERT INTO AUDITORIA ( NERROR, MENSAJE, FECHA, USUARIO ) 
                   VALUES(VERROR,VMES,SYSDATE, USER);    
END;



