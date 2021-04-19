package proyecto.persistencia.entidad;

import lombok.Getter;
import lombok.Setter;

import javax.persistence.Entity;
import javax.persistence.Id;
import javax.persistence.ManyToOne;
import java.io.Serializable;

@Entity
@Getter
@Setter
public class Favorito implements Serializable {

    @Id
    private int id;

    @ManyToOne
    private Usuario usuario;

    @ManyToOne
    private Lugar lugar;

}
