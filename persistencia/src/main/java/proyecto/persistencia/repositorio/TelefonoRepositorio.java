package proyecto.persistencia.repositorio;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import proyecto.persistencia.entidad.Categoria;
import proyecto.persistencia.entidad.Telefono;

@Repository
public interface TelefonoRepositorio extends JpaRepository<Telefono, Integer> {
}


