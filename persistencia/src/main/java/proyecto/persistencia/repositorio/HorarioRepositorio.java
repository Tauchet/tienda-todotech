package proyecto.persistencia.repositorio;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import proyecto.persistencia.entidad.Favorito;
import proyecto.persistencia.entidad.Horario;

@Repository
public interface HorarioRepositorio extends JpaRepository<Horario, Integer> {
}


