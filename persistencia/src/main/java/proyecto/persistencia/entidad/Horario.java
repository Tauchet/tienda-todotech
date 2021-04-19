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
    @GeneratedValue (strategy = GenerationType.AUTO)
    private int id;

    private String horario;

    @OneToOne
    private Lugar lugar;

}
