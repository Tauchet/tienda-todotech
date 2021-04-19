package proyecto.persistencia.repositorio;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import proyecto.persistencia.entidad.Horario;
import proyecto.persistencia.entidad.Imagen;

@Repository
public interface ImagenRepositorio extends JpaRepository<Imagen, Integer> {
}


