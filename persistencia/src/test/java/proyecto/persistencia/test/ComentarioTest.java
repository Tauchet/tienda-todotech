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
public class ComentarioTest {

    @Autowired
    private CiudadRepositorio ciudadRepositorio;

    @Autowired
    private UsuarioRepositorio usuarioRepositorio;

    @Autowired
    private CategoriaRepositorio categoriaRepositorio;

    @Autowired
    private LugarRepositorio lugarRepositorio;

    @Autowired
    private ComentarioRepositorio comentarioRepositorio;

    @Test
    public void registrarComentario() {

        // Creación de ciudades
        Ciudad ciudad = ciudadRepositorio.save(crearCiudadPrueba());
        Usuario lugarPropietario = usuarioRepositorio.save(crearUsuarioPrueba1(ciudad));
        Usuario usuario = usuarioRepositorio.save(crearUsuarioPrueba2(ciudad));
        Categoria categoria = categoriaRepositorio.save(crearCategoriaPrueba());
        Lugar lugar = lugarRepositorio.save(crearLugarPrueba(categoria, ciudad, lugarPropietario));

        // Creación del comentario
        Comentario comentario = crearComentario(usuario, lugar);

        // Guardamos los datos creados
        Comentario resultado = comentarioRepositorio.save(comentario);

        // Validamos que se haya guardado la información
        Assertions.assertNotNull(resultado);

    }

    @Test
    public void editarComentario() {

        // Creación de ciudades
        Ciudad ciudad = ciudadRepositorio.save(crearCiudadPrueba());
        Usuario lugarPropietario = usuarioRepositorio.save(crearUsuarioPrueba1(ciudad));
        Usuario usuario = usuarioRepositorio.save(crearUsuarioPrueba2(ciudad));
        Categoria categoria = categoriaRepositorio.save(crearCategoriaPrueba());
        Lugar lugar = lugarRepositorio.save(crearLugarPrueba(categoria, ciudad, lugarPropietario));

        Comentario resultadoCreacion = comentarioRepositorio.save(crearComentario(usuario, lugar));

        // Busqueda de la ciudad a modificar
        Comentario comentario = comentarioRepositorio.findById(resultadoCreacion.getId()).orElse(null);
        comentario.setRespuesta("Gracias, si, es muy buen producto!");

        // Guardamos los datos creados
        Comentario resultado = comentarioRepositorio.save(comentario);

        // Validamos que se haya guardado la información
        Assertions.assertNotNull(resultado);

    }

    @Test
    public void eliminarComentario() {

        // Creación de ciudades
        Ciudad ciudad = ciudadRepositorio.save(crearCiudadPrueba());
        Usuario lugarPropietario = usuarioRepositorio.save(crearUsuarioPrueba1(ciudad));
        Usuario usuario = usuarioRepositorio.save(crearUsuarioPrueba2(ciudad));
        Categoria categoria = categoriaRepositorio.save(crearCategoriaPrueba());
        Lugar lugar = lugarRepositorio.save(crearLugarPrueba(categoria, ciudad, lugarPropietario));

        Comentario resultadoCreacion = comentarioRepositorio.save(crearComentario(usuario, lugar));

        // Busqueda de la ciudad a modificar
        Comentario comentario = comentarioRepositorio.findById(resultadoCreacion.getId()).orElse(null);
        Assertions.assertNotNull(comentario);

        // Eliminemos la ciudad
        comentarioRepositorio.delete(comentario);

        // Buscamos de nuevo la ciudad
        Comentario busquedaComentario = comentarioRepositorio.findById(resultadoCreacion.getId()).orElse(null);
        Assertions.assertNull(busquedaComentario);

    }

    @Test
    @Sql("classpath:comentarios.sql")
    public void listarComentariosTest() {
        List<Comentario> lista = comentarioRepositorio.findAll();
        System.out.println(lista);
    }

    private Comentario crearComentario(Usuario usuario, Lugar lugar) {
        Comentario comentario = new Comentario();
        comentario.setTexto("Es un buen producto!");
        comentario.setCalificacion(5);
        comentario.setFechaComentario(new Date());
        comentario.setUsuario(usuario);
        comentario.setLugar(lugar);
        return comentario;
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

    private Usuario crearUsuarioPrueba1(Ciudad ciudad) {
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

    private Usuario crearUsuarioPrueba2(Ciudad ciudad) {
        Usuario usuario = new Usuario();
        usuario.setEmail("pepito@gmail.com");
        usuario.setAvatarUrl("http://www.w3bai.com/w3css/img_avatar3.png");
        usuario.setUsername("pepito");
        usuario.setPassword("holi133");
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
