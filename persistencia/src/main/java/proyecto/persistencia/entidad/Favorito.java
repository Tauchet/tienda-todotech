package proyecto.persistencia.entidad;

import lombok.Getter;
import lombok.Setter;

import javax.persistence.*;
import java.io.Serializable;

@Entity
@Getter
@Setter
public class Favorito implements Serializable {

    @Id
    @GeneratedValue (strategy = GenerationType.AUTO)
    private int id;

    @ManyToOne
    private Usuario usuario;

    @ManyToOne
    private Lugar lugar;

}
