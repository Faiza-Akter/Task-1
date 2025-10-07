function togglePassword(){
  const pwd = document.getElementById('password');
  const eye = document.getElementById('eyeIcon');
  if(pwd.type === 'password'){
    pwd.type = 'text';
    eye.className = 'fa-regular fa-eye-slash';
  } else {
    pwd.type = 'password';
    eye.className = 'fa-regular fa-eye';
  }
}

const form = document.querySelector('form');
form.addEventListener('submit', function(){
  const btn = form.querySelector('.submit-btn');
  btn.disabled = true;
  btn.style.opacity = 0.95;
  btn.textContent = 'Registering...';
});
