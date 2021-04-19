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
public class Imagen implements Serializable {

    @Id
    private int id;

    private String url;

    @ManyToOne
    private Lugar lugar;

}
