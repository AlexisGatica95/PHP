
    const formularios_ajax=document.querySelectorAll(".FormularioAjax");

    function enviar_formulario_ajax(e){
        e.preventDefault();
    
        let enviar=confirm("Quieres enviar el formulario");
    
        if(enviar==true){
    
            let data= new FormData(this);
            let method=this.getAttribute("method");
            let action=this.getAttribute("action");
    
            let encabezados= new Headers();
    
            let config={
                method: method,
                headers: encabezados,
                mode: 'cors',
                cache: 'no-cache',
                body: data
            };

            fetch(action,config)
            .then(respuesta => respuesta.json())
            .then(data => {
                if (data.redirect) {
                    window.location.href = data.redirect; // Redirección en JavaScript
                } else {
                // muestro la respuesta en mi contenedor 
                console.log(data);
                let contenedor=document.querySelector(".form-rest");
                contenedor.innerHTML = respuesta
                console.log(data)
                }
            });
    
            fetch(action,config)
            .then(respuesta => respuesta.text())
            .then(respuesta =>{ 
                
                // muestro la respuesta en mi contenedor 
                let contenedor=document.querySelector(".form-rest");
                contenedor.innerHTML = respuesta
                console.log(respuesta)
            });
        }
    
    }

    formularios_ajax.forEach(formularios => {
        formularios.addEventListener("submit",enviar_formulario_ajax);
    });
