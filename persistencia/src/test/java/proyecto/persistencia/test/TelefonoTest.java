package proyecto.persistencia.test;


import org.junit.jupiter.api.Assertions;
import org.junit.jupiter.api.Test;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.autoconfigure.jdbc.AutoConfigureTestDatabase;
import org.springframework.boot.test.autoconfigure.orm.jpa.DataJpaTest;
import org.springframework.test.context.jdbc.Sql;
import proyecto.persistencia.entidad.*;
import proyecto.persistencia.repositorio.*;

import java.util.Date;
import java.util.List;

@DataJpaTest
@AutoConfigureTestDatabase(replace = AutoConfigureTestDatabase.Replace.NONE)
public class TelefonoTest {

    @Autowired
    private CiudadRepositorio ciudadRepositorio;

    @Autowired
    private UsuarioRepositorio usuarioRepositorio;

    @Autowired
    private CategoriaRepositorio categoriaRepositorio;

    @Autowired
    private LugarRepositorio lugarRepositorio;

    @Autowired
    private TelefonoRepositorio telefonoRepositorio;

    @Test
    public void registrarImagen() {

        // Creación de los datos previos
        Ciudad ciudad = ciudadRepositorio.save(crearCiudadPrueba());
        Usuario lugarPropietario = usuarioRepositorio.save(crearUsuarioPrueba(ciudad));
        Categoria categoria = categoriaRepositorio.save(crearCategoriaPrueba());
        Lugar lugar = lugarRepositorio.save(crearLugarPrueba(categoria, ciudad, lugarPropietario));

        // Creación del telefono
        Telefono telefono = crearTelefonoPrueba(lugar);

        // Guardamos los datos creados
        Telefono resultado = telefonoRepositorio.save(telefono);

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

        Telefono resultadoCreacion = telefonoRepositorio.save(crearTelefonoPrueba(lugar));

        // Busqueda del telefono a modificar
        Telefono telefono = telefonoRepositorio.findById(resultadoCreacion.getId()).orElse(null);
        telefono.setNumero(3148001564L);

        // Guardamos los datos creados
        Telefono resultado = telefonoRepositorio.save(telefono);

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

        Telefono resultadoCreacion = telefonoRepositorio.save(crearTelefonoPrueba(lugar));

        // Busqueda del telefono a modificar
        Telefono telefono = telefonoRepositorio.findById(resultadoCreacion.getId()).orElse(null);
        Assertions.assertNotNull(telefono);

        // Eliminemos el telefono
        telefonoRepositorio.delete(telefono);

        // Buscamos de nuevo el telefono
        Telefono busqueda = telefonoRepositorio.findById(resultadoCreacion.getId()).orElse(null);
        Assertions.assertNull(busqueda);

    }

    @Test
    @Sql("classpath:telefonos.sql")
    public void listarTelefonosTest() {
        List<Telefono> lista = telefonoRepositorio.findAll();
        System.out.println(lista);
    }

    private Telefono crearTelefonoPrueba(Lugar lugar) {
        Telefono telefono = new Telefono();
        telefono.setNumero(3148001563L);
        telefono.setLugar(lugar);
        return telefono;
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
