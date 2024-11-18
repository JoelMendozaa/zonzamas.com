CREATE DATABASE horario;

CREATE TABLE 

CREATE TABLE 

CREATE TABLE 

CREATE TABLE 

CREATE TABLE 

CREATE TABLE 

CREATE TABLE 


personas
    id PK
    nombre
    apellido_1
    apellido_2
    nif
    email
    --datos auditoría
    ip_alta         
    fecha_alta      
    ip_ult_mod      
    fecha_ult_mod   


alumnos
    id PK
    id_persona FK
    --datos auditoría
    ip_alta         
    fecha_alta      
    ip_ult_mod      
    fecha_ult_mod   

profesores
    id PK
    id_persona FK
    id_modulo_tutoria 
    --datos auditoría
    ip_alta         
    fecha_alta      
    ip_ult_mod      
    fecha_ult_mod   

modulos
    id PK
    nombre
    id_profesor FK
    --datos auditoría
    ip_alta         
    fecha_alta      
    ip_ult_mod      
    fecha_ult_mod   

horario
    id PK
    id_modulo FK
    dia -- L,M,X,J,V,S,D
    hora_desde
    hora_hasta

    --datos auditoría
    ip_alta         
    fecha_alta      
    ip_ult_mod      
    fecha_ult_mod   


--opcional, pero no para crear el horario sino para saber qué modulos tiene cada alumno. 
modulos_alumnos
    id PK
    id_modulo
    id_alumno

    --datos auditoría
    ip_alta         
    fecha_alta      
    ip_ult_mod      
    fecha_ult_mod   