document.addEventListener('DOMContentLoaded', () => {
    
    const tipoRegistro = document.getElementById('tipo-registro');
    const inputUsername = document.getElementById('username-login');
    const inputEmail = document.getElementById('email-login');
    const formularioRegistro = document.getElementById('register-form');
    const pass = document.getElementById('password');
    const confirmPass = document.getElementById('confirm-password');
    const mensajeError = document.getElementById('contenedor-errores');

    if (tipoRegistro && inputUsername && inputEmail) {
        inputEmail.style.display = 'none'; // Estado inicial

        manageLoginOption();
        
    }

    if (formularioRegistro && pass && confirmPass) {
        comparePasswordsOnRegister();
    }

    function manageLoginOption(){
            tipoRegistro.addEventListener('change', (event) => {
                if (event.target.value === '1') {
                    inputUsername.style.display = 'inline-block';
                    inputEmail.style.display = 'none';
                } else {
                    inputUsername.style.display = 'none';
                    inputEmail.style.display = 'inline-block';
                }
            });
        }


    function comparePasswordsOnRegister() {
    formularioRegistro.addEventListener('submit', (e) => {
        const listaErrores = document.getElementById('lista-errores-js');
        
        // 1. Limpiamos estados previos
        if (mensajeError) {
            mensajeError.style.display = 'none';
            if (listaErrores) listaErrores.innerHTML = ''; // Limpiamos mensajes anteriores
        }

        // 2. Validación lógica
        if (pass.value !== confirmPass.value) {
            e.preventDefault(); // Detenemos el envío
            
            if (mensajeError && listaErrores) {
                // Creamos el mensaje de error dinámicamente
                const li = document.createElement('li');
                li.textContent = "Las contraseñas introducidas no coinciden.";
                listaErrores.appendChild(li);

                // Mostramos el contenedor y aplicamos estilos visuales
                mensajeError.style.display = 'block';
                pass.style.border = '2px solid red';
                confirmPass.style.border = '2px solid red';
            }
        }
    });
}


});