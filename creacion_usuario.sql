alter session set "_ORACLE_SCRIPT"=true;  
CREATE USER hospital_admin IDENTIFIED BY hospital_admin123;
GRANT CONNECT TO hospital_admin;
GRANT RESOURCE TO hospital_admin;
GRANT DBA TO hospital_admin;