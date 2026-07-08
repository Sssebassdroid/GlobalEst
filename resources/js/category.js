let tagsArray = [];
const categoryInput = document.getElementById('category-input');
const hiddenInput = document.getElementById('categories-data');
const selectedCategories = document.getElementById('selected-tags');

function selectCategory() {
    selectExistingCategory();
    selectNewCategory();
}


function selectExistingCategory(){
    categoryInput.addEventListener('input', function() {

        const valor = this.value.trim();

        const datalist = document.getElementById('categories-list');

        const options = Array.from(datalist.options).map(opt => opt.value);

        if (options.includes(valor)) {

            procesarNuevoTag(valor);

            this.value = ''; // Limpiar el input inmediatamente
            this.blur();
            this.focus();
        }


    });
}

function selectNewCategory(){
    categoryInput.addEventListener('keydown', function(event) {

        if (event.key === 'Enter') {

            event.preventDefault(); // Evitar envío del formulario

            const valor = this.value.trim();

            if (valor !== "") {

                procesarNuevoTag(valor);

                this.value = ''; // Limpiar el input
            }
        }
    });
}

function procesarNuevoTag(valor) {
    if (!tagsArray.includes(valor)) {
        tagsArray.push(valor);
        renderTag(valor);
        updateHiddenInput();

        // Quitar la opción del datalist para que no se repita en las sugerencias
        const datalist = document.getElementById('categories-list');
        const option = Array.from(datalist.options).find(opt => opt.value === valor);
        if (option) {
            option.remove();
        }
    }
}

function renderTag(name) {
    const tag = document.createElement('span');

    // Añadimos una clase para que la busques en tu CSS
    tag.className = 'custom-tag';

    // Inyectamos el nombre y el botón que llama a removeCategory
    tag.innerHTML = `
        ${name}
        <span class="remove-btn" onclick="window.removeCategory('${name}', this)">×</span>
    `;

    selectedCategories.appendChild(tag);
}

function updateHiddenInput() {
    hiddenInput.value = JSON.stringify(tagsArray);
}

window.removeCategory = function(name, element) {
    tagsArray = tagsArray.filter(t => t !== name);

    // 2. Eliminar el elemento visual
    element.parentElement.remove();

    // 3. Devolver la opción al datalist para que vuelva a estar disponible
    const datalist = document.getElementById('categories-list');
    const newOption = document.createElement('option');
    newOption.value = name;
    datalist.appendChild(newOption);

    // 4. Actualizar el input oculto
    updateHiddenInput();
};

document.addEventListener('DOMContentLoaded', () => {
    selectCategory();

    // Buscamos el formulario
const tourForm = document.getElementById('tour-form');

if (tourForm) {
    tourForm.addEventListener('submit', function(e) {
        // Forzamos una última actualización del input oculto antes de salir
        updateHiddenInput();

        // Log de depuración para que lo veas en la consola antes de que cambie la página
        console.log("Enviando categorías:", hiddenInput.value);

        // Validación extra: si el array está vacío, podrías incluso frenar el envío
        if (tagsArray.length === 0) {
            e.preventDefault();
            alert("Debes añadir al menos una categoría pulsando Enter.");
        }
    });
}
});
