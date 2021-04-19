package me.persistencia.entidad;

import lombok.Getter;
import lombok.Setter;

import javax.persistence.*;
import java.io.Serializable;
import java.util.Date;
import java.util.List;

@Entity
@Getter
@Setter
public class Usuario implements Serializable {

    @Id
    private int id;

    private String email;
    private String password;
    private String nickname;
    private String nombre;
    private String avatar_url;

    @Enumerated(value = EnumType.STRING)
    private Rol rol;

    @OneToMany(mappedBy="usuario")
    private List<Lugar> lugares;

    @OneToMany(mappedBy="moderador")
    private List<Lugar> lugaresAprobados;

    @ManyToOne
    private Ciudad ciudad;

    @OneToMany(mappedBy="usuario")
    private List<Favorito> favoritos;

    @OneToMany(mappedBy="usuario")
    private List<Comentario> comentarios;

    @Temporal(TemporalType.TIMESTAMP)
    private Date fechaCreacion;


}
