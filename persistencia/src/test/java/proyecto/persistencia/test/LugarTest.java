package proyecto.persistencia.test;

import org.junit.jupiter.api.Assertions;
import org.junit.jupiter.api.Test;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.autoconfigure.jdbc.AutoConfigureTestDatabase;
import org.springframework.boot.test.autoconfigure.orm.jpa.DataJpaTest;
import org.springframework.test.context.jdbc.Sql;
import proyecto.persistencia.entidad.*;
import proyecto.persistencia.repositorio.CategoriaRepositorio;
import proyecto.persistencia.repositorio.CiudadRepositorio;
import proyecto.persistencia.repositorio.LugarRepositorio;
import proyecto.persistencia.repositorio.UsuarioRepositorio;

import java.util.Date;
import java.util.List;

@DataJpaTest
@AutoConfigureTestDatabase(replace = AutoConfigureTestDatabase.Replace.NONE)
public class LugarTest {

    @Autowired
    private CiudadRepositorio ciudadRepositorio;

    @Autowired
    private UsuarioRepositorio usuarioRepositorio;

    @Autowired
    private CategoriaRepositorio categoriaRepositorio;

    @Autowired
    private LugarRepositorio lugarRepositorio;

    @Test
    public void registrarLugar() {

        // Creación de los datos previos
        Ciudad ciudad = ciudadRepositorio.save(crearCiudadPrueba());
        Usuario usuario = usuarioRepositorio.save(crearUsuarioPrueba(ciudad));
        Categoria categoria = categoriaRepositorio.save(crearCategoriaPrueba());

        // Creación del lugar
        Lugar lugar = crearLugarPrueba(categoria, ciudad, usuario);

        // Guardamos los datos creados
        Lugar resultado = lugarRepositorio.save(lugar);

        // Validamos que se haya guardado la información
        Assertions.assertNotNull(resultado);

    }

    @Test
    public void editarLugar() {

        // Creación de los datos previos
        Ciudad ciudad = ciudadRepositorio.save(crearCiudadPrueba());
        Usuario usuario = usuarioRepositorio.save(crearUsuarioPrueba(ciudad));
        Categoria categoria = categoriaRepositorio.save(crearCategoriaPrueba());

        // Creación del lugar
        Lugar resultadoCreacion = lugarRepositorio.save(crearLugarPrueba(categoria, ciudad, usuario));

        // Busqueda del lugar a modificar
        Lugar busqueda = lugarRepositorio.findById(resultadoCreacion.getId()).orElse(null);

        // Cambiamos valores
        busqueda.setNombre("El Yate");

        // Guardamos los datos creados
        Lugar resultado = lugarRepositorio.save(busqueda);

        // Validamos que se haya guardado la información
        Assertions.assertNotNull(resultado);

    }

    @Test
    public void eliminarLugar() {

        // Creación de los datos previos
        Ciudad ciudad = ciudadRepositorio.save(crearCiudadPrueba());
        Usuario usuario = usuarioRepositorio.save(crearUsuarioPrueba(ciudad));
        Categoria categoria = categoriaRepositorio.save(crearCategoriaPrueba());

        // Creación del lugar
        Lugar resultadoCreacion = lugarRepositorio.save(crearLugarPrueba(categoria, ciudad, usuario));

        // Busqueda del lugar a modificar
        Lugar lugar = lugarRepositorio.findById(resultadoCreacion.getId()).orElse(null);
        Assertions.assertNotNull(lugar);

        // Eliminemos el lugar
        lugarRepositorio.delete(lugar);

        // Buscamos de nuevo el lugar
        Lugar busquedaLugar = lugarRepositorio.findById(resultadoCreacion.getId()).orElse(null);
        Assertions.assertNull(busquedaLugar);

    }

    @Test
    @Sql("classpath:lugares.sql")
    public void listarLugaresTest() {
        List<Lugar> lista = lugarRepositorio.findAll();
        System.out.println(lista);
    }

    private Lugar crearLugarPrueba(Categoria categoria, Ciudad ciudad, Usuario usuario) {
        Lugar lugar = new Lugar();
        lugar.setNombre("El Jate");
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
