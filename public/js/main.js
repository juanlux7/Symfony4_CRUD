
var citas = document.getElementById("citas");

if(citas){

    citas.addEventListener("click", e => {

        e.preventDefault();

        if(e.target.className === "ui negative basic button"){

            if(confirm("¿estas seguro de borrar esta cita?")){

                const id = e.target.getAttribute('data-id');
                
                    fetch(`/borrarCita/${id}`, {
                        method: 'DELETE'
                    }).then(res => window.location.reload()).catch(error => {
                        console.log(error)
                    });

            }
            
        }

    })


}