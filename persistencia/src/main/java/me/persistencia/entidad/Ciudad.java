package me.persistencia.entidad;

import lombok.Getter;
import lombok.Setter;

import javax.persistence.Entity;
import javax.persistence.Id;
import javax.persistence.OneToMany;
import java.io.Serializable;
import java.util.List;

@Entity
@Getter
@Setter
public class Ciudad implements Serializable {

    @Id
    private int id;

    private String nombre;

    @OneToMany(mappedBy="ciudad")
    private List<Usuario> usuarios;

    @OneToMany(mappedBy="ciudad")
    private List<Lugar> lugares;

}
