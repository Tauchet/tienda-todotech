package proyecto.persistencia.test;


import org.junit.jupiter.api.Assertions;
import org.junit.jupiter.api.Test;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.autoconfigure.jdbc.AutoConfigureTestDatabase;
import org.springframework.boot.test.autoconfigure.orm.jpa.DataJpaTest;
import org.springframework.test.context.jdbc.Sql;
import proyecto.persistencia.entidad.*;
import proyecto.persistencia.repositorio.*;

import java.util.ArrayList;
import java.util.Date;
import java.util.List;

@DataJpaTest
@AutoConfigureTestDatabase(replace = AutoConfigureTestDatabase.Replace.NONE)
public class HorarioTest {

    @Autowired
    private CiudadRepositorio ciudadRepositorio;

    @Autowired
    private UsuarioRepositorio usuarioRepositorio;

    @Autowired
    private CategoriaRepositorio categoriaRepositorio;

    @Autowired
    private LugarRepositorio lugarRepositorio;

    @Autowired
    private HorarioRepositorio horarioRepositorio;

    @Test
    public void registrarHorario() {

        // Creación de los datos previos
        Ciudad ciudad = ciudadRepositorio.save(crearCiudadPrueba());
        Usuario lugarPropietario = usuarioRepositorio.save(crearUsuarioPrueba(ciudad));
        Categoria categoria = categoriaRepositorio.save(crearCategoriaPrueba());
        Lugar lugar = lugarRepositorio.save(crearLugarPrueba(categoria, ciudad, lugarPropietario));

        // Creación del horario
        Horario horario = crearHorario(lugar);

        // Guardamos los datos creados
        Horario resultado = horarioRepositorio.save(horario);

        // Validamos que se haya guardado la información
        Assertions.assertNotNull(resultado);

    }

    @Test
    public void editarHorario() {

        // Creación de los datos previos
        Ciudad ciudad = ciudadRepositorio.save(crearCiudadPrueba());
        Usuario lugarPropietario = usuarioRepositorio.save(crearUsuarioPrueba(ciudad));
        Categoria categoria = categoriaRepositorio.save(crearCategoriaPrueba());
        Lugar lugar = lugarRepositorio.save(crearLugarPrueba(categoria, ciudad, lugarPropietario));

        Horario resultadoCreacion = horarioRepositorio.save(crearHorario(lugar));

        // Busqueda del horario a modificar
        Horario horario = horarioRepositorio.findById(resultadoCreacion.getId()).orElse(null);

        // Cambiar de que el lunes abre más temprano
        horario.setHorario("2 - 20; 10 - 20; 10 - 20; 10 - 20; 10 - 20; 10 - 20; NaN");

        // Guardamos los datos creados
        Horario resultado = horarioRepositorio.save(horario);

        // Validamos que se haya guardado la información
        Assertions.assertNotNull(resultado);

    }

    @Test
    public void eliminarHorario() {

        // Creación de los datos previos
        Ciudad ciudad = ciudadRepositorio.save(crearCiudadPrueba());
        Usuario lugarPropietario = usuarioRepositorio.save(crearUsuarioPrueba(ciudad));
        Categoria categoria = categoriaRepositorio.save(crearCategoriaPrueba());
        Lugar lugar = lugarRepositorio.save(crearLugarPrueba(categoria, ciudad, lugarPropietario));

        Horario resultadoCreacion = horarioRepositorio.save(crearHorario(lugar));

        // Busqueda del horario a modificar
        Horario horario = horarioRepositorio.findById(resultadoCreacion.getId()).orElse(null);
        Assertions.assertNotNull(horario);

        // Eliminemos el horario
        horarioRepositorio.delete(horario);

        // Buscamos de nuevo el horario
        Horario busqueda = horarioRepositorio.findById(resultadoCreacion.getId()).orElse(null);
        Assertions.assertNull(busqueda);

    }

    @Test
    @Sql("classpath:horarios.sql")
    public void listarHorariosTest() {
        List<Horario> lista = horarioRepositorio.findAll();
        System.out.println(lista);
    }


    private Horario crearHorario(Lugar lugar) {
        Horario horario = new Horario();
        horario.setHorario("10 - 20; 10 - 20; 10 - 20; 10 - 20; 10 - 20; 10 - 20; NaN");
        horario.setLugar(lugar);
        return horario;
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
