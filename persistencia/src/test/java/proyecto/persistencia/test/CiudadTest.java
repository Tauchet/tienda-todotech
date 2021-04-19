package proyecto.persistencia.test;


import org.junit.jupiter.api.Assertions;
import org.junit.jupiter.api.Test;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.autoconfigure.jdbc.AutoConfigureTestDatabase;
import org.springframework.boot.test.autoconfigure.orm.jpa.DataJpaTest;
import org.springframework.test.context.jdbc.Sql;
import proyecto.persistencia.entidad.Categoria;
import proyecto.persistencia.entidad.Ciudad;
import proyecto.persistencia.repositorio.CiudadRepositorio;

import java.util.List;

@DataJpaTest
@AutoConfigureTestDatabase(replace = AutoConfigureTestDatabase.Replace.NONE)
public class CiudadTest {

    @Autowired
    private CiudadRepositorio ciudadRepositorio;

    @Test
    public void registrarArmeniaCiudad() {

        // Creación de ciudades
        Ciudad ciudad = crearCiudadPrueba();

        // Guardamos los datos creados
        Ciudad resultado = ciudadRepositorio.save(ciudad);

        // Validamos que se haya guardado la información
        Assertions.assertNotNull(resultado);

    }

    @Test
    public void editarArmeniaCiudad() {

        // Creación de ciudades de prueba
        Ciudad resultadoCreacion = ciudadRepositorio.save(crearCiudadPrueba());

        // Busqueda de la ciudad a modificar
        Ciudad ciudad = ciudadRepositorio.findById(resultadoCreacion.getId()).orElse(null);
        ciudad.setNombre("Armenia - Quindio");

        // Guardamos los datos creados
        Ciudad resultado = ciudadRepositorio.save(ciudad);

        // Validamos que se haya guardado la información
        Assertions.assertNotNull(resultado);

    }

    @Test
    public void eliminarArmeniaCiudad() {

        // Creación de ciudades de prueba
        Ciudad resultadoCreacion = ciudadRepositorio.save(crearCiudadPrueba());

        // Busqueda de la ciudad a modificar
        Ciudad ciudad = ciudadRepositorio.findById(resultadoCreacion.getId()).orElse(null);
        Assertions.assertNotNull(ciudad);

        // Eliminemos la ciudad
        ciudadRepositorio.delete(ciudad);

        // Buscamos de nuevo la ciudad
        Ciudad busquedaCiudad = ciudadRepositorio.findById(resultadoCreacion.getId()).orElse(null);
        Assertions.assertNull(busquedaCiudad);

    }

    @Test
    @Sql("classpath:ciudades.sql")
    public void listarCiudadesTest() {
        List<Ciudad> lista = ciudadRepositorio.findAll();
        System.out.println(lista);
    }

    private Ciudad crearCiudadPrueba() {
        Ciudad nuevaCiudad = new Ciudad();
        nuevaCiudad.setNombre("Armenia");
        return nuevaCiudad;
    }

}
