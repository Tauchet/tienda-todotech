# Creación de Ciudades
INSERT INTO ciudad(id, nombre) VALUES (0, "Armenia");
INSERT INTO ciudad(id, nombre) VALUES (1, "Medellin");
INSERT INTO ciudad(id, nombre) VALUES (2, "Bogota");

# Creación de Usuarios
INSERT INTO usuario(id, email, username, password, nombre, avatar_url, rol, fecha_creacion, ciudad_id) VALUES (0, "tauchet@gmail.com", "tauchet", "holi123", "Pepito", "https://th.bing.com/th/id/OIP.uTYylcQG5H8NwHAKG5ediwAAAA?pid=ImgDet&rs=1", "USUARIO", "2020/02/12", (select id from ciudad where id=1));
INSERT INTO usuario(id, email, username, password, nombre, avatar_url, rol, fecha_creacion, ciudad_id) VALUES (1, "tauchet1@gmail.com", "tauchet1", "holi1233", "Antonio", "https://th.bing.com/th/id/OIP.uTYylcQG5H8NwHAKG5ediwAAAA?pid=ImgDet&rs=1", "MODERADOR", "2020/02/20", (select id from ciudad where id=0));
INSERT INTO usuario(id, email, username, password, nombre, avatar_url, rol, fecha_creacion, ciudad_id) VALUES (2, "tauchet2@gmail.com", "tauchet2", "holi1234", "Julito", "https://th.bing.com/th/id/OIP.uTYylcQG5H8NwHAKG5ediwAAAA?pid=ImgDet&rs=1", "ADMINISTRADOR", "2020/02/2", (select id from ciudad where id=2));
