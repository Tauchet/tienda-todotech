package proyecto.persistencia.test;

import org.junit.jupiter.api.Assertions;
import org.junit.jupiter.api.Test;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.autoconfigure.jdbc.AutoConfigureTestDatabase;
import org.springframework.boot.test.autoconfigure.orm.jpa.DataJpaTest;
import org.springframework.test.context.jdbc.Sql;
import proyecto.persistencia.entidad.Ciudad;
import proyecto.persistencia.entidad.Rol;
import proyecto.persistencia.entidad.Usuario;
import proyecto.persistencia.repositorio.CiudadRepositorio;
import proyecto.persistencia.repositorio.UsuarioRepositorio;

import java.util.Date;
import java.util.List;

@DataJpaTest
@AutoConfigureTestDatabase(replace = AutoConfigureTestDatabase.Replace.NONE)
public class UsuarioTest {

    @Autowired
    private UsuarioRepositorio usuarioRepositorio;

    @Autowired
    private CiudadRepositorio ciudadRepositorio;

    @Test
    public void registrarUsuario() {

        // Creación de los datos previos
        Ciudad ciudadPrueba = crearCiudadPrueba();
        Ciudad ciudadOrigen = ciudadRepositorio.save(ciudadPrueba);

        // Validamos que se haya guardado la información
        Assertions.assertNotNull(ciudadOrigen);

        // Creamos el usuario
        Usuario usuario = crearUsuarioPrueba(ciudadOrigen);

        // Guardamos el dato del usuario
        Usuario resultado = usuarioRepositorio.save(usuario);

        // Validamos que se haya guardado la información
        Assertions.assertNotNull(resultado);

    }

    @Test
    public void editarUsuario() {

        // Creación de los datos previos
        Ciudad ciudadPrueba = crearCiudadPrueba();
        ciudadPrueba = ciudadRepositorio.save(ciudadPrueba);

        // Validamos que se haya guardado la información
        Assertions.assertNotNull(ciudadPrueba);

        // Creamos el usuario
        Usuario usuario = crearUsuarioPrueba(ciudadPrueba);
        int usuarioId = usuarioRepositorio.save(usuario).getId();

        // Buscamos el usuario
        Usuario busqueda = usuarioRepositorio.findById(usuarioId).orElse(null);
        Assertions.assertNotNull(busqueda);

        // Modificamos datos
        busqueda.setRol(Rol.MODERADOR);

        // Guardamos datos
        Usuario resultado = usuarioRepositorio.save(busqueda);

        // Validamos datos
        Assertions.assertNotNull(resultado);

    }

    @Test
    public void eliminarUsuario() {

        // Creación de los datos previos
        Ciudad ciudadPrueba = crearCiudadPrueba();
        ciudadPrueba = ciudadRepositorio.save(ciudadPrueba);

        // Validamos que se haya guardado la información
        Assertions.assertNotNull(ciudadPrueba);

        // Creamos el usuario
        Usuario usuario = crearUsuarioPrueba(ciudadPrueba);
        int usuarioId = usuarioRepositorio.save(usuario).getId();

        // Buscamos el usuario
        Usuario busqueda = usuarioRepositorio.findById(usuarioId).orElse(null);
        Assertions.assertNotNull(busqueda);

        // Eliminemos el usuario
        usuarioRepositorio.delete(busqueda);

        // Guardamos datos
        Usuario busquedaNueva = usuarioRepositorio.findById(usuarioId).orElse(null);
        Assertions.assertNull(busquedaNueva);

    }

    @Test
    @Sql("classpath:usuarios.sql")
    public void listarUsuariosTest() {
        List<Usuario> lista = usuarioRepositorio.findAll();
        System.out.println(lista);
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
        nuevaCiudad.setId(104540);
        nuevaCiudad.setNombre("Armenia");
        return nuevaCiudad;
    }

}
