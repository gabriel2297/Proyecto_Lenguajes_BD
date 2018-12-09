SET SERVEROUTPUT ON;

-- para que aparezca la hora y minutos
alter session set nls_date_format = 'dd/MON/yyyy hh24:mi:ss'

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
    CONSTRAINT FK_ID_TIPO_SANGRE FOREIGN KEY (id_tipo_sangre) REFERENCES tipo_sangre(sang_id_tipo),
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
    ecedula VARCHAR2(12) NOT NULL PRIMARY KEY,
    enombre VARCHAR2(30) NOT NULL,
    eapellido1 VARCHAR2(30) NOT NULL,
    eapellido2 VARCHAR2(30) NOT NULL,
    etelefono VARCHAR2(9) NOT NULL,
    ecorreo_electronico VARCHAR2(100) NOT NULL,
    efecha_nacimiento DATE NOT NULL,
    id_departamento number not null,
    id_trabajo number not null,
    econtrasenha varchar2(255)
    CONSTRAINT EHK_CEDULA CHECK (REGEXP_LIKE(ecedula, '^[0-1][1-7](-)[0-9]{4}(-)[0-9]{4}$')),
    CONSTRAINT EHK_TELEFONO CHECK (REGEXP_LIKE(etelefono, '^[0-9]{4}(-)[0-9]{4}$')),
    CONSTRAINT EHK_CORREO CHECK (REGEXP_LIKE(ecorreo_electronico, '^.+@[a-z]+(\.com)$')),
    CONSTRAINT FK_ID_DEPARTAMENTO FOREIGN KEY (id_departamento) REFERENCES departamento(id_departamento),
    CONSTRAINT FK_ID_TRABAJO FOREIGN KEY (id_trabajo) REFERENCES trabajo(id_trabajo)
);

alter table empleado add econtrasenha varchar2(255) not null;

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
    observaciones varchar2(1500),
    id_tipo_cita number not null,
    id_estado_cita NUMBER NOT NULL,
    FOREIGN KEY(cedula_paciente) REFERENCES paciente(cedula),
    FOREIGN KEY(cedula_empleado) REFERENCES empleado(ecedula),
    FOREIGN KEY(num_sala) REFERENCES salas(num_salas),
    FOREIGN KEY(id_tipo_cita) references tipo_cita(id_tipo_cita),
    FOREIGN KEY(id_estado_cita) REFERENCES estado_cita(id_estado)
);

CREATE TABLE estado_cita(
    id_estado NUMBER NOT NULL PRIMARY KEY,
    estado VARCHAR2(20)
);

CREATE TABLE auditoria(
	NERROR NUMBER,
	MENSAJE  VARCHAR2(500), 
	FECHA DATE,
	USUARIO VARCHAR2(50)
);

/* SECUENCIAS DE AUTOINCREMENTO */
CREATE SEQUENCE tipo_sala_secuencia START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE num_salas_secuencia START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE num_cita_secuencia START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE num_id_trabajo START WITH 1 INCREMENT BY 1;

/* INSERCION DE DATOS NECESARIOS */

-- generos
INSERT INTO genero (id_genero, genero) VALUES ('M', 'Masculino');
INSERT INTO genero (id_genero, genero) VALUES ('F', 'Femenino');

-- tipo de sangre
INSERT INTO tipo_sangre (sang_id_tipo, sang_tipo) VALUES (1, 'O negativo');
INSERT INTO tipo_sangre (sang_id_tipo, sang_tipo) VALUES (2, 'O positivo');

--departamentos
INSERT INTO departamento (id_departamento,departamento) VALUES (1, 'Dermatología');
INSERT INTO departamento (id_departamento,departamento) VALUES (2, 'Ginecología');

--trabajo
INSERT INTO trabajo (id_trabajo,titulo_trabajo) VALUES (num_id_trabajo.NEXTVAL, 'Medico');
INSERT INTO trabajo (id_trabajo,titulo_trabajo) VALUES (num_id_trabajo.NEXTVAL, 'Admin');
INSERT INTO trabajo (id_trabajo,titulo_trabajo) VALUES (1, 'Médico');
INSERT INTO trabajo (id_trabajo,titulo_trabajo) VALUES (2, 'Técnico');
INSERT INTO trabajo (id_trabajo,titulo_trabajo) VALUES (3, 'Asistente');

--Tipo sala
INSERT INTO tipo_sala (id_tipo, tipo) VALUES (tipo_sala_secuencia.NEXTVAL, 'Transplantes');
INSERT INTO tipo_sala (id_tipo, tipo) VALUES (tipo_sala_secuencia.NEXTVAL, 'Cirugía');
INSERT INTO tipo_sala (id_tipo, tipo) VALUES (tipo_sala_secuencia.NEXTVAL, 'Partos');

--Salas
INSERT INTO salas (num_salas, id_tipo) VALUES (num_salas_secuencia.NEXTVAL, 1);
INSERT INTO salas (num_salas, id_tipo) VALUES (num_salas_secuencia.NEXTVAL, 2);
INSERT INTO salas (num_salas, id_tipo) VALUES (num_salas_secuencia.NEXTVAL, 3);

--tipo_cita
INSERT INTO tipo_cita (id_tipo_cita, tipo_cita) VALUES (1, 'Consulta');
INSERT INTO tipo_cita (id_tipo_cita, tipo_cita) VALUES (2, 'Revision General');
INSERT INTO tipo_cita (id_tipo_cita, tipo_cita) VALUES (3, 'Seguimiento');

-- salas
INSERT INTO tipo_sala (id_tipo, tipo) VALUES (tipo_sala_secuencia.NEXTVAL, 'Consultorio');
INSERT INTO tipo_sala (id_tipo, tipo) VALUES (tipo_sala_secuencia.NEXTVAL, 'Partos');
INSERT INTO tipo_sala (id_tipo, tipo) VALUES (tipo_sala_secuencia.NEXTVAL, 'Almacen');
INSERT INTO tipo_sala (id_tipo, tipo) VALUES (tipo_sala_secuencia.NEXTVAL, 'Habitacion');
INSERT INTO tipo_sala (id_tipo, tipo) VALUES (tipo_sala_secuencia.NEXTVAL, 'Emergencias');

-- estado citas
INSERT INTO estado_cita (id_estado, estado) VALUES (1, 'Pendiente');
INSERT INTO estado_cita (id_estado, estado) VALUES (2, 'Completa');

/* PROCEDIMIENTOS ALMACENADOS */
select * from empleado;

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
	VERROR NUMBER;
	VEXP exception;
	VMES VARCHAR2(500);
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
	ELSE
		RAISE vexp;
    END IF;
    EXCEPTION
		WHEN VEXP THEN
		   VERROR := SQLCODE;
		   VMES := 'El Paciente ya existe ';
		   INSERT INTO AUDITORIA ( NERROR, MENSAJE, FECHA, USUARIO) VALUES(VERROR,VMES,SYSDATE, USER);
		WHEN  OTHERS  THEN
			VERROR := SQLCODE;
			VMES := SQLERRM;
			dbms_output.put_line(VMES);
			INSERT INTO AUDITORIA (NERROR, MENSAJE, FECHA, USUARIO ) VALUES(VERROR,VMES,SYSDATE, USER);    
END;

execute agregar_paciente('11-0723-0822','Pepe','Rodriguez','Centeno','8401-9915','14/10/1998','Juan1958@hotmail.com','2262-7879',1,'M',65,175);
execute agregar_paciente('11-0723-0800','Pepe0','Rodriguez','Centeno','8401-9915','14/10/1998','Juan1958@hotmail.com','2262-7879',1,'M',65,175);
execute agregar_paciente('11-0723-0801','Pepe1','Rodriguez','Centeno','8401-9915','14/10/1998','Juan1958@hotmail.com','2262-7879',1,'M',65,175);
execute agregar_paciente('11-0723-0802','Pepe2','Rodriguez','Centeno','8401-9915','14/10/1998','Juan1958@hotmail.com','2262-7879',1,'M',65,175);
execute agregar_paciente('11-0723-0803','Pepe3','Rodriguez','Centeno','8401-9915','14/10/1998','Juan1958@hotmail.com','2262-7879',1,'M',65,175);
execute agregar_paciente('11-0723-0804','Pepe4','Rodriguez','Centeno','8401-9915','14/10/1998','Juan1958@hotmail.com','2262-7879',1,'M',65,175);
execute agregar_paciente('11-0723-0805','Pepe5','Rodriguez','Centeno','8401-9915','14/10/1998','Juan1958@hotmail.com','2262-7879',1,'M',65,175);
execute agregar_paciente('11-0723-0806','Pepe6','Rodriguez','Centeno','8401-9915','14/10/1998','Juan1958@hotmail.com','2262-7879',1,'M',65,175);
execute agregar_paciente('11-0723-0807','Pepe7','Rodriguez','Centeno','8401-9915','14/10/1998','Juan1958@hotmail.com','2262-7879',1,'M',65,175);
execute agregar_paciente('11-0723-0808','Pepe8','Rodriguez','Centeno','8401-9915','14/10/1998','Juan1958@hotmail.com','2262-7879',1,'M',65,175);
execute agregar_paciente('11-0723-0809','Pepe9','Rodriguez','Centeno','8401-9915','14/10/1998','Juan1958@hotmail.com','2262-7879',1,'M',65,175);
execute agregar_paciente('11-0723-0810','Pepe10','Rodriguez','Centeno','8401-9915','14/10/1998','Juan1958@hotmail.com','2262-7879',1,'M',65,175);
execute agregar_paciente('11-0723-0811','Pepe11','Rodriguez','Centeno','8401-9915','14/10/1998','Juan1958@hotmail.com','2262-7879',1,'M',65,175);
execute agregar_paciente('11-0723-0812','Pepe12','Rodriguez','Centeno','8401-9915','14/10/1998','Juan1958@hotmail.com','2262-7879',1,'M',65,175);

--Agregar empleado
CREATE OR REPLACE PROCEDURE agregar_empleado(
	cedula in varchar2,
	nombre in VARCHAR2,
	apellido1 in varchar2,
	apellido2 in VARCHAR2,
	telefono VARCHAR2,
	correo_electronico in VARCHAR2,
	fecha_nacimiento in varchar2,
	id_departamento in number,
	id_trabajo in number,
    contrasenha in varchar2)
as
	VERROR NUMBER;
	VMES VARCHAR2(500);
	total NUMBER;
	VEXP exception;
begin
	total := 0;
    SELECT COUNT(*) INTO total FROM empleado WHERE ecedula = cedula;
     IF total = 0 THEN
        INSERT INTO empleado(ecedula,
                             enombre,
                             eapellido1,
                             eapellido2,
                             etelefono,
                             ecorreo_electronico,
                             efecha_nacimiento,
                             id_departamento,
                             id_trabajo,
                             econtrasenha)
        VALUES (cedula,
                nombre,
                apellido1,
                apellido2,
                telefono,
                correo_electronico,
                TO_DATE(fecha_nacimiento, 'DD-MM-YYYY'),
                id_departamento,
                id_trabajo,
                contrasenha);
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


INSERT INTO paciente_x_tratamiento (id_tratamiento, cedula, FECHA_RECETA) VALUES (1, '01-1674-0099', sysdate);

execute agregar_empleado('01-1111-2222','medico','medico','medico','7698-0232','medico@correo.com','19/07/1980', 1, 1, 'password');
execute agregar_empleado('01-1111-2223','admin','admin','admin','7698-0232','admin@correo.com','19/07/1980', 1, 2, 'password');
execute agregar_empleado('01-1111-2224','administrador','administrador','administrador','7698-0232','administrador@correo.com','19/07/1980', 1, 2, 'password');


-- procedimiento almacenado para completar cita
CREATE OR REPLACE PROCEDURE completar_cita(num_cita IN NUMBER, observaciones_cita IN VARCHAR2)
AS
	VERROR NUMBER;
	VEXP exception;
	VMES VARCHAR2(500);
	total NUMBER;
	cont number;
BEGIN
    -- revisar si ese numero de cita existe
    total := 0;
    SELECT COUNT(*) INTO total FROM cita WHERE id_cita = num_cita;

    -- si existe, hacer update
    IF total = 1 THEN
        UPDATE cita SET observaciones = observaciones_cita, id_estado_cita = 2 WHERE id_cita = num_cita;
    ELSE
        raise  VEXP;
    END IF;
    exception
    WHEN VEXP THEN
              dbms_output.put_line(VMES);
       VERROR := SQLCODE;
       VMES := 'No existe una cita con ese numero.';
       INSERT INTO AUDITORIA ( NERROR, MENSAJE, FECHA, USUARIO) 
             VALUES(VERROR,VMES,SYSDATE, USER);
    WHEN  OTHERS  THEN
       VERROR := SQLCODE;
       VMES := SQLERRM;
        dbms_output.put_line(VMES);
END;

-- procedimiento almacenado para agregar cita
create or replace procedure crear_cita( cedulaP in varchar2,
                                        cedulaE in varchar2,
                                        numSala in number,
                                        fechaH in varchar2,
                                        idTipoCita in number,
                                        id_estadoCita in NUMBER)
as
	VERROR NUMBER;
	VEXP exception;
	VMES VARCHAR2(500);
	total NUMBER;
	cont number;
BEGIN
    -- revisar si ya existe alguna cita en ese consultorio a esa hora
    total := 0;
    SELECT COUNT(*) INTO total FROM cita WHERE fecha_hora = TO_DATE(fechaH,  'DD-MM-YYYY HH24:MI') AND num_sala = numSala;

    -- no hay citas a esa hora en ese consultorio, agregar a la persona
    IF total = 0 THEN
        INSERT INTO cita(id_cita,
                         cedula_paciente,
                         cedula_empleado,
                         num_sala,
                         fecha_hora,
                         id_tipo_cita,
                         id_estado_cita) 
        VALUES (num_cita_secuencia.NEXTVAL,
                cedulaP,
                cedulaE,
                numSala,
                TO_DATE(fechah, 'DD-MM-YYYY HH24:MI'),
                idTipoCita,
                id_estadoCita);
    ELSE
        raise  VEXP;
    END IF;
    exception
    WHEN VEXP THEN
              dbms_output.put_line(VMES);
       VERROR := SQLCODE;
       VMES := 'Ya hay una cita programada para esa hora en el consultorio indicado';
       INSERT INTO AUDITORIA ( NERROR, MENSAJE, FECHA, USUARIO) 
             VALUES(VERROR,VMES,SYSDATE, USER);
    WHEN  OTHERS  THEN
       VERROR := SQLCODE;
       VMES := SQLERRM;
        dbms_output.put_line(VMES);
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

-- procedimiento almacenado para eliminar un tratamiento
CREATE OR REPLACE PROCEDURE eliminar_tratamiento(
    codigo IN NUMBER
)
IS
BEGIN
    DELETE FROM tratamientos WHERE id_tratamiento = codigo;
END;

-- procedimiento almacenado para editar un tratamiento
CREATE OR REPLACE PROCEDURE editar_tratamiento(
    codigo IN NUMBER,
    descripcion IN VARCHAR2
)
IS
BEGIN
    UPDATE tratamientos SET tratamiento = descripcion WHERE id_tratamiento = codigo;
END;

-- procedimiento almacenado para agregar una sala
CREATE OR REPLACE PROCEDURE agregar_sala(
    id_tipo_sala IN NUMBER)
IS
BEGIN
    INSERT INTO salas(num_salas, id_tipo) VALUES (num_salas_secuencia.NEXTVAL, id_tipo_sala);
END;

-- procedimiento almacenado para eliminar una sala
CREATE OR REPLACE PROCEDURE eliminar_sala(
    numero_sala IN NUMBER)
IS
BEGIN
    DELETE FROM salas WHERE num_salas = numero_sala;
END;

-- procedimiento almacenado para editar una sala
CREATE OR REPLACE PROCEDURE editar_sala(
    tipo_de_sala IN NUMBER,
    numero_sala IN NUMBER)
AS
BEGIN
    UPDATE salas SET id_tipo = tipo_de_sala WHERE num_salas = numero_sala;
END;

/* FUNCIONES */

-- buscar las citas por medico
CREATE OR REPLACE FUNCTION obtener_citas_medico(cedulaMedico IN VARCHAR2)
RETURN SYS_REFCURSOR
AS
    DATOS SYS_REFCURSOR;
    sql_din VARCHAR(1000);
BEGIN
    sql_din := 'SELECT c.id_cita, estado.estado estado_cita, c.num_sala, TO_CHAR(c.fecha_hora, ''DD-MM-YYYY HH24:MI'') fecha_hora, c.observaciones, t.tipo_cita, e.ecedula, e.enombre, e.eapellido1, e.eapellido2, p.cedula, p.nombre, p.apellido1, p.apellido2
                FROM empleado e, paciente p, cita c, tipo_cita t, estado_cita estado
                WHERE c.cedula_paciente = p.cedula AND c.cedula_empleado = e.ecedula
                AND c.id_tipo_cita = t.id_tipo_cita AND e.ecedula = :cedulaMedico AND estado.id_estado = 1 AND c.id_estado_cita = estado.id_estado';
    OPEN DATOS FOR sql_din USING cedulaMedico;
    RETURN DATOS;
END;

-- buscar las citas por paciente
CREATE OR REPLACE FUNCTION obtener_citas_paciente(cedulaPaciente IN VARCHAR2)
RETURN SYS_REFCURSOR
AS
    DATOS SYS_REFCURSOR;
    sql_din VARCHAR(1000);
BEGIN
    sql_din := 'SELECT c.id_cita, estado.estado estado_cita, c.num_sala, TO_CHAR(c.fecha_hora, ''DD-MM-YYYY HH24:MI'') fecha_hora, c.observaciones, t.tipo_cita, e.ecedula, e.enombre, e.eapellido1, e.eapellido2, p.cedula, p.nombre, p.apellido1, p.apellido2
                FROM empleado e, paciente p, cita c, tipo_cita t, estado_cita estado
                WHERE c.cedula_paciente = p.cedula AND c.cedula_empleado = e.ecedula
                AND c.id_tipo_cita = t.id_tipo_cita AND p.cedula = :cedulaPaciente AND estado.id_estado = 1 AND c.id_estado_cita = estado.id_estado';
    OPEN DATOS FOR sql_din USING cedulaPaciente;
    RETURN DATOS;
END;

-- buscar las citas para un medico en una fecha especifica
CREATE OR REPLACE FUNCTION obtener_citas_medico_x_fecha(cedulaMedico IN VARCHAR2, fecha_revisar IN VARCHAR2)
RETURN SYS_REFCURSOR
AS
    DATOS SYS_REFCURSOR;
    sql_din VARCHAR2(1000);
BEGIN
    sql_din := 'SELECT c.id_cita, c.num_sala, TO_CHAR(c.fecha_hora, ''DD-MM-YYYY HH24:MI'') fecha_hora, c.observaciones, t.tipo_cita, e.ecedula, e.enombre, e.eapellido1, e.eapellido2, p.cedula, p.nombre, p.apellido1, p.apellido2
                FROM empleado e, paciente p, cita c, tipo_cita t
                WHERE c.cedula_paciente = p.cedula AND c.cedula_empleado = :cedulaMedico
                AND c.id_tipo_cita = t.id_tipo_cita AND c.fecha_hora = TO_DATE(:fecha_revisar,  ''DD-MM-YYYY HH24:MI'')
                AND c.cedula_empleado = e.ecedula';
    OPEN DATOS FOR sql_din USING cedulaMedico, fecha_revisar;
    RETURN DATOS;
END;

-- buscar todas las citas para una fecha especifica
CREATE OR REPLACE FUNCTION obtener_citas_en_fecha(fecha_revisar IN VARCHAR2)
RETURN SYS_REFCURSOR
AS
    DATOS SYS_REFCURSOR;
    sql_din VARCHAR(1000);
BEGIN
    sql_din := '    SELECT c.id_cita, c.num_sala, TO_CHAR(c.fecha_hora, ''DD-MM-YYYY HH24:MI'') fecha_hora, c.observaciones, t.tipo_cita, e.ecedula, e.enombre, e.eapellido1, e.eapellido2, p.cedula, p.nombre, p.apellido1, p.apellido2
                    FROM empleado e, paciente p, cita c, tipo_cita t
                    WHERE c.id_tipo_cita = t.id_tipo_cita AND c.fecha_hora = TO_DATE(:fecha_revisar,  ''DD-MM-YYYY HH24:MI'')';
    OPEN DATOS FOR sql_din USING fecha_revisar;
    RETURN DATOS;
END;

-- buscar tratamientos de un paciente
CREATE OR REPLACE FUNCTION buscar_tratamientos_paciente(cedulaPaciente IN VARCHAR2)
RETURN SYS_REFCURSOR
AS
    DATOS SYS_REFCURSOR;
    sql_din VARCHAR2(500);
BEGIN
    sql_din := 'SELECT t.tratamiento, x.fecha_receta 
                FROM tratamientos t, paciente_x_tratamiento x, paciente p
                WHERE t.id_tratamiento = x.id_tratamiento
                AND x.cedula = p.cedula AND p.cedula = :cedulaPaciente';
    OPEN DATOS FOR sql_din USING cedulaPaciente;
    RETURN DATOS;
END;

-- funcion para eliminar un paciente
CREATE OR REPLACE FUNCTION eliminar_paciente(cedula_paciente IN VARCHAR2)
RETURN VARCHAR2
AS
    mensaje_retorno VARCHAR2(50);
    total NUMBER;
    sql_din VARCHAR2(100);
    codigo_error NUMBER;
    mensaje_error VARCHAR2(32000);
BEGIN
    sql_din := 'DELETE FROM paciente WHERE cedula = :cedula_paciente';
    total := 0;
    SELECT COUNT(*) INTO total FROM paciente WHERE cedula = cedula_paciente;
    IF total = 1 THEN
        EXECUTE IMMEDIATE sql_din USING cedula_paciente;
        mensaje_retorno := 'Eliminado';
    ELSE
        mensaje_retorno := 'Error';
    END IF;
    RETURN mensaje_retorno;
     EXCEPTION
      WHEN NO_DATA_FOUND THEN
         codigo_error := SQLCODE;
         mensaje_error := SQLERRM;
         DBMS_OUTPUT.PUT_LINE('ERROR NUMERO ' || codigo_error || ' ' || mensaje_error);
      WHEN TOO_MANY_ROWS THEN
         codigo_error := SQLCODE;
         mensaje_error := SQLERRM;
         DBMS_OUTPUT.PUT_LINE('ERROR NUMERO ' || codigo_error || ' ' || mensaje_error);
      WHEN OTHERS THEN
         codigo_error := SQLCODE;
         mensaje_error := SQLERRM;
         DBMS_OUTPUT.PUT_LINE('ERROR NUMERO ' || codigo_error || ' ' || mensaje_error);
END;

-- funcion para editar un paciente
CREATE OR REPLACE FUNCTION editar_paciente(
    cedula_paciente IN VARCHAR2,
    nombre_paciente IN VARCHAR2,
    apellido1_paciente IN VARCHAR2,
    apellido2_paciente IN VARCHAR2,
    telefono_paciente IN VARCHAR2,
    correo_paciente IN VARCHAR2,
    telefono_sos_paciente IN VARCHAR2,
    peso_paciente IN NUMBER,
    altura_paciente IN NUMBER
)
RETURN VARCHAR2
AS
    mensaje_retorno VARCHAR2(100);
    total NUMBER;
    sql_din VARCHAR2(2000);
    codigo_error NUMBER;
    mensaje_error VARCHAR2(32000);
BEGIN
    sql_din := 'UPDATE paciente SET nombre = :nombre_paciente,
                                    apellido1 = :apellido1_paciente,
                                    apellido2 = :apellido2_paciente,
                                    telefono = :telefono_paciente,
                                    correo_electronico = :correo_paciente,
                                    telefono_sos = :telefono_sos_paciente,
                                    peso = :peso_paciente,
                                    altura = :altura_paciente
                                    WHERE cedula = :cedula_paciente';
    total := 0;
    SELECT COUNT(*) INTO total FROM paciente WHERE cedula = cedula_paciente;
    IF total = 1 THEN
        EXECUTE IMMEDIATE sql_din USING nombre_paciente, apellido1_paciente, apellido2_paciente, telefono_paciente, correo_paciente, telefono_sos_paciente, peso_paciente, altura_paciente, cedula_paciente;
        mensaje_retorno := 'Editado';
        RETURN mensaje_retorno;
    ELSE
        mensaje_retorno := 'Error';
        RETURN mensaje_retorno;
    END IF;
     EXCEPTION
      WHEN NO_DATA_FOUND THEN
         codigo_error := SQLCODE;
         mensaje_error := SQLERRM;
         DBMS_OUTPUT.PUT_LINE('ERROR NUMERO ' || codigo_error || ' ' || mensaje_error);
      WHEN TOO_MANY_ROWS THEN
         codigo_error := SQLCODE;
         mensaje_error := SQLERRM;
         DBMS_OUTPUT.PUT_LINE('ERROR NUMERO ' || codigo_error || ' ' || mensaje_error);
      WHEN OTHERS THEN
         codigo_error := SQLCODE;
         mensaje_error := SQLERRM;
         DBMS_OUTPUT.PUT_LINE('ERROR NUMERO ' || codigo_error || ' ' || mensaje_error);
END;

CREATE OR REPLACE FUNCTION editar_empleado(
    cedula_empleado IN VARCHAR2,
    nombre_empleado IN VARCHAR2,
    apellido1_empleado IN VARCHAR2,
    apellido2_empleado IN VARCHAR2,
    telefono_empleado IN VARCHAR2,
    correo_empleado IN VARCHAR2
)
RETURN VARCHAR2
AS
    mensaje_retorno VARCHAR2(100);
    total NUMBER;
    sql_din VARCHAR2(2000);
    codigo_error NUMBER;
    mensaje_error VARCHAR2(32000);
BEGIN
    sql_din := 'UPDATE empleado SET enombre = :nombre_empleado,
                                    eapellido1 = :apellido1_empleado,
                                    eapellido2 = :apellido2_empleado,
                                    etelefono = :telefono_empleado,
                                    ecorreo_electronico = :correo_empleado
                                    WHERE ecedula = :cedula_empleado';
    total := 0;
    SELECT COUNT(*) INTO total FROM empleado WHERE ecedula = cedula_empleado;
    IF total = 1 THEN
        EXECUTE IMMEDIATE sql_din USING nombre_empleado, apellido1_empleado, apellido2_empleado, telefono_empleado, correo_empleado, cedula_empleado;
        mensaje_retorno := 'Editado';
        RETURN mensaje_retorno;
    ELSE
        mensaje_retorno := 'Error';
        RETURN mensaje_retorno;
    END IF;
     EXCEPTION
      WHEN NO_DATA_FOUND THEN
         codigo_error := SQLCODE;
         mensaje_error := SQLERRM;
         DBMS_OUTPUT.PUT_LINE('ERROR NUMERO ' || codigo_error || ' ' || mensaje_error);
      WHEN TOO_MANY_ROWS THEN
         codigo_error := SQLCODE;
         mensaje_error := SQLERRM;
         DBMS_OUTPUT.PUT_LINE('ERROR NUMERO ' || codigo_error || ' ' || mensaje_error);
      WHEN OTHERS THEN
         codigo_error := SQLCODE;
         mensaje_error := SQLERRM;
         DBMS_OUTPUT.PUT_LINE('ERROR NUMERO ' || codigo_error || ' ' || mensaje_error);
END;

-- funcion para eliminar un empleado
CREATE OR REPLACE FUNCTION eliminar_empleado(cedula_empleado IN VARCHAR2)
RETURN VARCHAR2
AS
    mensaje_retorno VARCHAR2(50);
    total NUMBER;
    sql_din VARCHAR2(100);
    codigo_error NUMBER;
    mensaje_error VARCHAR2(32000);
BEGIN
    sql_din := 'DELETE FROM empleado WHERE ecedula = :cedula_empleado';
    total := 0;
    SELECT COUNT(*) INTO total FROM empleado WHERE ecedula = cedula_empleado;
    IF total = 1 THEN
        EXECUTE IMMEDIATE sql_din USING cedula_empleado;
        mensaje_retorno := 'Eliminado';
    ELSE
        mensaje_retorno := 'Error';
    END IF;
    RETURN mensaje_retorno;
     EXCEPTION
      WHEN NO_DATA_FOUND THEN
         codigo_error := SQLCODE;
         mensaje_error := SQLERRM;
         DBMS_OUTPUT.PUT_LINE('ERROR NUMERO ' || codigo_error || ' ' || mensaje_error);
      WHEN TOO_MANY_ROWS THEN
         codigo_error := SQLCODE;
         mensaje_error := SQLERRM;
         DBMS_OUTPUT.PUT_LINE('ERROR NUMERO ' || codigo_error || ' ' || mensaje_error);
      WHEN OTHERS THEN
         codigo_error := SQLCODE;
         mensaje_error := SQLERRM;
         DBMS_OUTPUT.PUT_LINE('ERROR NUMERO ' || codigo_error || ' ' || mensaje_error);
END;

/* TRIGGERS */

-- trigger que elimina las llaves foraneas en la tabla de paciente_x_tratamiento antes de borrar el primary key en la tabla paciente
CREATE OR REPLACE TRIGGER eliminar_paciente
BEFORE DELETE ON paciente
FOR EACH ROW
BEGIN
    DELETE FROM paciente_x_tratamiento WHERE cedula = :OLD.cedula;
END;

-- trigger que elimina las llaves foraneas en la tabla de citas antes de borrar el primary key en la tabla empleado
CREATE OR REPLACE TRIGGER eliminar_empleado
BEFORE DELETE ON empleado
FOR EACH ROW
BEGIN
    DELETE FROM cita WHERE cedula_empleado = :OLD.ecedula;
END;

-- trigger para eliminar las llaves foraneas en la tabla de citas antes de borrar el primary key en la tabla de salas
CREATE OR REPLACE TRIGGER eliminar_sala
BEFORE DELETE ON salas
FOR EACH ROW
BEGIN
    DELETE FROM cita WHERE num_sala = :OLD.num_salas;
END;

-- trigger para eliminar las llaves foraneas de la tabla de pacientes antes de borrar el primary key en la tabla de tratamientos
CREATE OR REPLACE TRIGGER eliminar_tratamiento
BEFORE DELETE ON tratamientos
FOR EACH ROW
BEGIN
    DELETE FROM paciente_x_tratamiento WHERE id_tratamiento = :OLD.id_tratamiento;
END;


