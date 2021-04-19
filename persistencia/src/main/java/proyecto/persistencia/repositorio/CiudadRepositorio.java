package proyecto.persistencia.repositorio;

import proyecto.persistencia.entidad.Ciudad;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface CiudadRepositorio extends JpaRepository<Ciudad, Integer> {
}

