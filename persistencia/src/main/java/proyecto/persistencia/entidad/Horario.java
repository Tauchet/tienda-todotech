package proyecto.persistencia.entidad;

import lombok.Getter;
import lombok.Setter;

import javax.persistence.*;
import java.io.Serializable;
import java.util.List;

@Entity
@Getter
@Setter
public class Horario implements Serializable {

    @Id
    private int id;

    @ElementCollection
    public List<Integer> horasDeInicio;

    @ElementCollection
    public List<Integer> horasDeCerrado;

    @OneToOne
    private Lugar lugar;

}
