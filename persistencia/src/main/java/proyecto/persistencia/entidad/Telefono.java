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
public class Telefono implements Serializable {

    @Id
    private int id;

    private int numero;

    @ManyToOne
    private Lugar lugar;

}
