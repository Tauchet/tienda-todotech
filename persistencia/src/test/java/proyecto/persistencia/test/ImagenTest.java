package proyecto.persistencia.test;


import org.junit.jupiter.api.Assertions;
import org.junit.jupiter.api.Test;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.autoconfigure.jdbc.AutoConfigureTestDatabase;
import org.springframework.boot.test.autoconfigure.orm.jpa.DataJpaTest;
import org.springframework.test.context.jdbc.Sql;
import proyecto.persistencia.entidad.*;
import proyecto.persistencia.repositorio.*;

import java.awt.*;
import java.util.Date;
import java.util.List;

@DataJpaTest
@AutoConfigureTestDatabase(replace = AutoConfigureTestDatabase.Replace.NONE)
public class ImagenTest {

    @Autowired
    private CiudadRepositorio ciudadRepositorio;

    @Autowired
    private UsuarioRepositorio usuarioRepositorio;

    @Autowired
    private CategoriaRepositorio categoriaRepositorio;

    @Autowired
    private LugarRepositorio lugarRepositorio;

    @Autowired
    private ImagenRepositorio imagenRepositorio;

    @Test
    public void registrarImagen() {

        // Creación de los datos previos
        Ciudad ciudad = ciudadRepositorio.save(crearCiudadPrueba());
        Usuario lugarPropietario = usuarioRepositorio.save(crearUsuarioPrueba(ciudad));
        Categoria categoria = categoriaRepositorio.save(crearCategoriaPrueba());
        Lugar lugar = lugarRepositorio.save(crearLugarPrueba(categoria, ciudad, lugarPropietario));

        // Creación de la imagen
        Imagen imagen = crearImagen(lugar);

        // Guardamos los datos creados
        Imagen resultado = imagenRepositorio.save(imagen);

        // Validamos que se haya guardado la información
        Assertions.assertNotNull(resultado);

    }

    @Test
    public void editarImagen() {

        // Creación de los datos previos
        Ciudad ciudad = ciudadRepositorio.save(crearCiudadPrueba());
        Usuario lugarPropietario = usuarioRepositorio.save(crearUsuarioPrueba(ciudad));
        Categoria categoria = categoriaRepositorio.save(crearCategoriaPrueba());
        Lugar lugar = lugarRepositorio.save(crearLugarPrueba(categoria, ciudad, lugarPropietario));

        Imagen resultadoCreacion = imagenRepositorio.save(crearImagen(lugar));

        // Busqueda de la imagen a modificar
        Imagen imagen = imagenRepositorio.findById(resultadoCreacion.getId()).orElse(null);
        imagen.setUrl("https://www.lavanguardia.com/files/og_thumbnail/uploads/2020/12/14/5fd7240cadcfe.jpeg");

        // Guardamos los datos creados
        Imagen resultado = imagenRepositorio.save(imagen);

        // Validamos que se haya guardado la información
        Assertions.assertNotNull(resultado);

    }

    @Test
    public void eliminarImagen() {

        // Creación de los datos previos
        Ciudad ciudad = ciudadRepositorio.save(crearCiudadPrueba());
        Usuario lugarPropietario = usuarioRepositorio.save(crearUsuarioPrueba(ciudad));
        Categoria categoria = categoriaRepositorio.save(crearCategoriaPrueba());
        Lugar lugar = lugarRepositorio.save(crearLugarPrueba(categoria, ciudad, lugarPropietario));

        Imagen resultadoCreacion = imagenRepositorio.save(crearImagen(lugar));

        // Busqueda de la imagen a modificar
        Imagen imagen = imagenRepositorio.findById(resultadoCreacion.getId()).orElse(null);
        Assertions.assertNotNull(imagen);

        // Eliminemos la imagen
        imagenRepositorio.delete(imagen);

        // Buscamos de nuevo la imagen
        Imagen busqueda = imagenRepositorio.findById(resultadoCreacion.getId()).orElse(null);
        Assertions.assertNull(busqueda);

    }

    @Test
    @Sql("classpath:imagenes.sql")
    public void listarImagenesTest() {
        List<Imagen> lista = imagenRepositorio.findAll();
        System.out.println(lista);
    }

    private Imagen crearImagen(Lugar lugar) {
        Imagen imagen = new Imagen();
        imagen.setUrl("https://upload.wikimedia.org/wikipedia/commons/4/45/A_small_cup_of_coffee.JPG");
        imagen.setLugar(lugar);
        return imagen;
    }

    private Lugar crearLugarPrueba(Categoria categoria, Ciudad ciudad, Usuario usuario) {
        Lugar lugar = new Lugar();
        lugar.setNombre("El Yate");
        lugar.setDescripcion("Un lugar mágico.");
        lugar.setLatitud(7.6365);
        lugar.setLongitud(-23.9390);
        lugar.setEstado(LugarEstado.ESPERANDO);
        lugar.setCiudad(ciudad);
        lugar.setCategoria(categoria);
        lugar.setUsuario(usuario);
        lugar.setFechaCreacion(new Date());
        return lugar;
    }

    private Usuario crearUsuarioPrueba(Ciudad ciudad) {
        Usuario usuario = new Usuario();
        usuario.setEmail("tauchet@gmail.com");
        usuario.setAvatarUrl("http://www.w3bai.com/w3css/img_avatar3.png");
        usuario.setUsername("tauchet");
        usuario.setPassword("holi123");
        usuario.setCiudad(ciudad);
        usuario.setRol(Rol.USUARIO);
        usuario.setFechaCreacion(new Date());
        return usuario;
    }

    private Ciudad crearCiudadPrueba() {
        Ciudad nuevaCiudad = new Ciudad();
        nuevaCiudad.setNombre("Armenia");
        return nuevaCiudad;
    }

    private Categoria crearCategoriaPrueba() {
        Categoria nuevaCategoria = new Categoria();
        nuevaCategoria.setNombre("Bar");
        return nuevaCategoria;
    }


}
