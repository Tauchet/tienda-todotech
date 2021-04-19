package proyecto.persistencia.repositorio;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import proyecto.persistencia.entidad.Lugar;
import proyecto.persistencia.entidad.Telefono;

@Repository
public interface LugarRepositorio extends JpaRepository<Lugar, Integer> {
}


