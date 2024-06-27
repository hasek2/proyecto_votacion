document.addEventListener('DOMContentLoaded', function() {
    loadRegions();
    loadCandidates();

    document.getElementById('region').addEventListener('change', function() {
        loadComunas(this.value);
    });

    document.getElementById('votacionForm').addEventListener('submit', function(event) {
        event.preventDefault();

        if (validateForm()) {
            fetch('guardar_voto.php', {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
            });
        }
    });

    function loadRegions() {
        fetch('get_regiones.php')
            .then(response => response.json())
            .then(data => {
                let regionSelect = document.getElementById('region');
                data.forEach(region => {
                    regionSelect.innerHTML += `<option value="${region.id}">${region.nombre}</option>`;
                });
            });
    }

    function loadComunas(region_id) {
        fetch(`get_comunas.php?region_id=${region_id}`)
            .then(response => response.json())
            .then(data => {
                let comunaSelect = document.getElementById('comuna');
                comunaSelect.innerHTML = '<option value="">Seleccione</option>';
                data.forEach(comuna => {
                    comunaSelect.innerHTML += `<option value="${comuna.id}">${comuna.nombre}</option>`;
                });
            });
    }

    function loadCandidates() {
        fetch('get_candidatos.php')
            .then(response => response.json())
            .then(data => {
                let candidatoSelect = document.querySelector('select[name="candidato"]');
                data.forEach(candidato => {
                    candidatoSelect.innerHTML += `<option value="${candidato.id}">${candidato.nombre}</option>`;
                });
            });
    }

    function validateForm() {
        let valid = true;
        const nombre = document.getElementById('nombre').value.trim();
        const alias = document.getElementById('alias').value.trim();
        const rut = document.getElementById('rut').value.trim();
        const email = document.getElementById('email').value.trim();
        const enteradoPor = document.querySelectorAll('input[name="medio_entero[]"]:checked').length;

        if (nombre === "") {
            alert('El nombre y apellido no debe quedar en blanco.');
            valid = false;
        }

        if (!/^(?=.*[a-zA-Z])(?=.*\d)[A-Za-z\d]{6,}$/.test(alias)) {
            alert('El alias debe tener al menos 6 caracteres y contener letras y números.');
            valid = false;
        }

        if (!validateRut(rut)) {
            alert('El RUT no es válido.');
            valid = false;
        }

        if (!validateEmail(email)) {
            alert('El correo electrónico no es válido.');
            valid = false;
        }

        if (enteradoPor < 2) {
            alert('Debe seleccionar al menos dos opciones en "¿Cómo se enteró de Nosotros?".');
            valid = false;
        }

        return valid;
    }

    function validateRut(rut) {
        // Eliminar espacios en blanco y convertir guion en minúscula si es 'K'
        rut = rut.replace(/\s/g, '').toLowerCase();
        
        // Validar formato con puntos y guion
        return /^\d{1,2}\.\d{3}\.\d{3}-\d{1}$/.test(rut);
    }

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
});
