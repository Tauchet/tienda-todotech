package proyecto.persistencia.entidad;

import lombok.Getter;
import lombok.Setter;

import javax.persistence.*;
import java.io.Serializable;
import java.util.List;

@Entity
@Getter
@Setter
public class Ciudad implements Serializable {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private int id;

    private String nombre;

    @OneToMany(mappedBy="ciudad")
    private List<Usuario> usuarios;

    @OneToMany(mappedBy="ciudad")
    private List<Lugar> lugares;

}
