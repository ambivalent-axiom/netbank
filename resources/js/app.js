import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
//Registration form dynamics
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
//Create transaction account dynamics
document.addEventListener('DOMContentLoaded', function () {
    const fromAccountSelect = document.getElementById('from_account');
    const currencyField = document.getElementById('currency');
    const balanceField = document.getElementById('balance');

    fromAccountSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const currency = selectedOption.getAttribute('data-currency');
        const balance = selectedOption.getAttribute('data-balance');

        currencyField.textContent = `${currency}`;
        balanceField.textContent = `${balance}`;
        if (currency === null || currency.trim() === '') {
            currencyField.classList.add('hidden');
        } else {
            currencyField.classList.remove('hidden');
        }
        if (balance === null || balance.trim() === '') {
            balanceField.classList.add('hidden');
        } else {
            balanceField.classList.remove('hidden');
        }
    });

    fromAccountSelect.dispatchEvent(new Event('change'));
});
//Create transaction contact dynamics
document.addEventListener('DOMContentLoaded', function () {
    const contactSelect = document.getElementById('contact');
    const accountField = document.getElementById('receiver_account');

    contactSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const account = selectedOption.getAttribute('data-account');

        accountField.value = `Account: ${account}` ? account : 'Default Value';;
    });
    contactSelect.dispatchEvent(new Event('change'));
});
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    const tableBody = document.querySelector('tbody');

    searchInput.addEventListener('input', function () {
        const searchTerm = searchInput.value.toLowerCase();
        const rows = tableBody.querySelectorAll('tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            let rowContainsSearchTerm = false;

            cells.forEach(cell => {
                if (cell.textContent.toLowerCase().includes(searchTerm)) {
                    rowContainsSearchTerm = true;
                }
            });

            if (rowContainsSearchTerm) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
