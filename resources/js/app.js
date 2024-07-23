import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    const businessRadio = document.querySelector('input[name="type"][value="business"]');
    const privateRadio = document.querySelector('input[name="type"][value="private"]');
    const businessNameField = document.getElementById('company');
    function toggleBusinessNameField() {
        if (businessRadio.checked) {
            businessNameField.classList.remove('hidden');
        } else {
            businessNameField.classList.add('hidden');
        }
    }
    businessRadio.addEventListener('change', toggleBusinessNameField);
    privateRadio.addEventListener('change', toggleBusinessNameField);
    toggleBusinessNameField();
})
