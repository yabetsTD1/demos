const form = document.getElementById('signupForm');
const password = document.getElementById('password');
const confirmPassword = document.getElementById('confirmPassword');

form.addEventListener('submit', (e) => {
    if (password.value !== confirmPassword.value) {
        e.preventDefault();
        alert('Passwords do not match!');
    }
});