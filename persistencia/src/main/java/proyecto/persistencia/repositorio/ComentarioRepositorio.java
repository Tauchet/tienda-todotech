package proyecto.persistencia.repositorio;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import proyecto.persistencia.entidad.Comentario;
import proyecto.persistencia.entidad.Lugar;

@Repository
public interface ComentarioRepositorio extends JpaRepository<Comentario, Integer> {
}


