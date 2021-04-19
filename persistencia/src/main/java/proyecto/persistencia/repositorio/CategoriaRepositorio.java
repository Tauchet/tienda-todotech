package proyecto.persistencia.repositorio;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import proyecto.persistencia.entidad.Categoria;
import proyecto.persistencia.entidad.Ciudad;

@Repository
public interface CategoriaRepositorio extends JpaRepository<Categoria, Integer> {
}

