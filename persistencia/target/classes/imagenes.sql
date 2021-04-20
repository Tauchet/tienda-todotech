# Creación de Ciudades (viene desde el ciudades.sql)
INSERT INTO ciudad(id, nombre) VALUES (0, "Armenia");
INSERT INTO ciudad(id, nombre) VALUES (1, "Medellin");
INSERT INTO ciudad(id, nombre) VALUES (2, "Bogota");

# Creación de Usuarios (viene desde el usuarios.sql)
INSERT INTO usuario(id, email, username, password, nombre, avatar_url, rol, fecha_creacion, ciudad_id) VALUES (0, "tauchet@gmail.com", "tauchet", "holi123", "Pepito", "https://th.bing.com/th/id/OIP.uTYylcQG5H8NwHAKG5ediwAAAA?pid=ImgDet&rs=1", "USUARIO", "2020/02/12", (select id from ciudad where id=1));
INSERT INTO usuario(id, email, username, password, nombre, avatar_url, rol, fecha_creacion, ciudad_id) VALUES (1, "tauchet1@gmail.com", "tauchet1", "holi1233", "Antonio", "https://th.bing.com/th/id/OIP.uTYylcQG5H8NwHAKG5ediwAAAA?pid=ImgDet&rs=1", "MODERADOR", "2020/02/20", (select id from ciudad where id=0));
INSERT INTO usuario(id, email, username, password, nombre, avatar_url, rol, fecha_creacion, ciudad_id) VALUES (2, "tauchet2@gmail.com", "tauchet2", "holi1234", "Julito", "https://th.bing.com/th/id/OIP.uTYylcQG5H8NwHAKG5ediwAAAA?pid=ImgDet&rs=1", "ADMINISTRADOR", "2020/02/2", (select id from ciudad where id=2));

# Creación de Categorias (viene desde el categorias.sql)
INSERT INTO categoria(id, nombre) VALUES (0, "Bar");
INSERT INTO categoria(id, nombre) VALUES (1, "Cafe");
INSERT INTO categoria(id, nombre) VALUES (2, "Supermecado");

# Creación de Lugares (viene desde el lugares.sql)
INSERT lugar(id, nombre, descripcion, latitud, longitud, estado, fecha_creacion, categoria_id, ciudad_id, usuario_id)
VALUES (0,
        "Cabra Loco",
        "Un café rico",
        10.5,
        2.45405,
        "ESPERANDO",
        "2002/05/19",
        (select id from categoria where id=0),
        (select id from ciudad where id=1),
        (select id from usuario where id=0));
INSERT lugar(id, nombre, descripcion, latitud, longitud, estado, fecha_creacion, categoria_id, ciudad_id, usuario_id)
VALUES (1,
        "Supermercado",
        "Super descuentos...",
        4.450450,
        -3.4405,
        "ESPERANDO",
        "2004/04/19",
        (select id from categoria where id=2),
        (select id from ciudad where id=0),
        (select id from usuario where id=2));
INSERT lugar(id, nombre, descripcion, latitud, longitud, estado, fecha_creacion, categoria_id, ciudad_id, usuario_id)
VALUES (2,
        "Hamburguis",
        "Una rica hamburguesa artesanal.",
        1.7870,
        -2.4540,
        "ESPERANDO",
        "2010/03/19",
        (select id from categoria where id=1),
        (select id from ciudad where id=2),
        (select id from usuario where id=1));

# Creación de Imagenes
INSERT INTO imagen(id, url, lugar_id)
VALUES (0,
        "https://ep01.epimg.net/elcomidista/imagenes/2017/09/27/articulo/1506522721_155894_1506523041_media_normal.jpg",
        (select id from lugar where id = 0));
INSERT INTO imagen(id, url, lugar_id)
VALUES (1,
        "https://as.com/deporteyvida/imagenes/2018/06/19/portada/1529402043_039778_1529402207_noticia_normal.jpg",
        (select id from lugar where id = 1));
INSERT INTO imagen(id, url, lugar_id)
VALUES (2,
        "https://estaticos.muyinteresante.es/uploads/images/gallery/5548e20741444aef0ed38e65/cafe15.jpg",
        (select id from lugar where id = 2));