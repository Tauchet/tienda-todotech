package proyecto.persistencia.test;

import org.junit.jupiter.api.Assertions;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.autoconfigure.jdbc.AutoConfigureTestDatabase;
import org.springframework.boot.test.autoconfigure.orm.jpa.DataJpaTest;
import org.springframework.test.context.jdbc.Sql;
import proyecto.persistencia.entidad.Categoria;
import proyecto.persistencia.entidad.Ciudad;
import proyecto.persistencia.entidad.Usuario;
import proyecto.persistencia.repositorio.CategoriaRepositorio;
import proyecto.persistencia.repositorio.CiudadRepositorio;

import java.util.List;

@DataJpaTest
@AutoConfigureTestDatabase(replace = AutoConfigureTestDatabase.Replace.NONE)
public class CategoriaTest {

    @Autowired
    private CategoriaRepositorio categoriaRepositorio;

    @Test
    public void registrarCategoria() {

        // Creación de la categoría
        Categoria ciudad = crearCategoriaPrueba();

        // Guardamos los datos creados
        Categoria resultado = categoriaRepositorio.save(ciudad);

        // Validamos que se haya guardado la información
        Assertions.assertNotNull(resultado);

    }

    @Test
    public void editarCategoria() {

        // Creación de ciudades de prueba
        Categoria resultadoCreacion = categoriaRepositorio.save(crearCategoriaPrueba());

        // Busqueda de la ciudad a modificar
        Categoria busqueda = categoriaRepositorio.findById(resultadoCreacion.getId()).orElse(null);

        // Cambiamos valores
        busqueda.setNombre("Bar y Café");

        // Guardamos los datos creados
        Categoria resultado = categoriaRepositorio.save(busqueda);

        // Validamos que se haya guardado la información
        Assertions.assertNotNull(resultado);

    }

    @Test
    public void eliminarCategoria() {

        // Creación de ciudades de prueba
        Categoria resultadoCreacion = categoriaRepositorio.save(crearCategoriaPrueba());

        // Busqueda de la categoria a modificar
        Categoria busqueda = categoriaRepositorio.findById(resultadoCreacion.getId()).orElse(null);
        Assertions.assertNotNull(busqueda);

        // Eliminemos la categoria
        categoriaRepositorio.delete(busqueda);

        // Buscamos de nuevo la categoria
        Categoria busquedaCategoria = categoriaRepositorio.findById(resultadoCreacion.getId()).orElse(null);
        Assertions.assertNull(busquedaCategoria);

    }

    @Test
    @Sql("classpath:categorias.sql")
    public void listarCategoriasTest() {
        List<Categoria> lista = categoriaRepositorio.findAll();
        System.out.println(lista);
    }

    private Categoria crearCategoriaPrueba() {
        Categoria nuevaCategoria = new Categoria();
        nuevaCategoria.setNombre("Bar");
        return nuevaCategoria;
    }

}
