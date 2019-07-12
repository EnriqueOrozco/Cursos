create database curso;

use curso;

create table articulo(
id int primary key identity(1,1), 
nombre nvarchar (30) not null, 
cantidad int not null,
precio float not null
);

insert into articulo values('Aceite Patrona',10,13.5)

select * from articulo


go
create proc EntradaArticulo(@nombre nvarchar(30),@cantidad int,@precio float)
as begin
insert into articulo values(@nombre,@cantidad,@precio)
end
go

go
create proc EliminarArticulo(@id int)
as begin
delete from articulo where id=@id
end
go

go
create proc BuscarArticulo(@id int)
as begin
select * from articulo where id=@id
end
go

---------------------------------------------------------

create table proveedor(
id int primary key identity(1,1), 
nombre nvarchar (30) not null, 
direccion nvarchar (30) not null,
telefono nvarchar (10) not null
);

insert into proveedor values('Patrona','Mexico','2351001010')

select * from proveedor


go
create proc EntradaProveedor(@nombre nvarchar(30),@direccion nvarchar(30),@telefono nvarchar(10))
as begin
insert into proveedor values(@nombre,@direccion,@telefono)
end
go

go
create proc EliminarProveedor(@id int)
as begin
delete from proveedor where id=@id
end
go

go
create proc BuscarProveedor(@id int)
as begin
select * from proveedor where id=@id
end
go



---CREACION DEL LOGIN ADMINISTRADOR---
create login curso
with password='1234',
default_database=curso

---CREACION DE USUARIO ADMINISTRADOR---
create user curso
for login curso
with default_schema=mi_esquema

---CREACION DE ESQUEMA PARA ADMINISTRADOR---
create schema mi_esquema authorization curso;

---CREACION DE PRIVILEGIOS PARA ADMINISTRADOR---
GRANT CREATE PROC,EXECUTE,CREATE TABLE, CREATE ROLE, SELECT,INSERT,UPDATE,DELETE TO curso;