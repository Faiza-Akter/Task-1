// Function to get initials from name 
function getInitials(name) {
    const words = name.trim().split(' ');
    let initials = '';
    const count = Math.min(3, words.length);
    for (let i = 0; i < count; i++) {
        if (words[i] && words[i][0]) {
            initials += words[i][0].toUpperCase();
        }
    }
    return initials;
}

// Load users via AJAX
async function loadUsers() {
    try {
        const res = await axios.get('api.php');
        if (res.data.status === 'success') {
            displayUsers(res.data.data);
        } else {
            console.error('Error loading users:', res.data.message);
            document.getElementById('usersList').innerHTML = '<li class="bg-white/20 backdrop-blur-md border border-white/30 rounded-xl p-8 text-center text-white">Error loading users</li>';
        }
    } catch (error) {
        console.error('Error loading users:', error);
        document.getElementById('usersList').innerHTML = '<li class="bg-white/20 backdrop-blur-md border border-white/30 rounded-xl p-8 text-center text-white">Error loading users. Please check console.</li>';
    }
}

// Display users in the list 
function displayUsers(users) {
    const usersList = document.getElementById('usersList');
    
    if (users.length === 0) {
        usersList.innerHTML = '<li class="bg-white/20 backdrop-blur-md border border-white/30 rounded-xl p-8 text-center text-white">No users registered yet.</li>';
        return;
    }

    usersList.innerHTML = users.map(user => `
        <li class="bg-white/20 backdrop-blur-md border border-white/30 rounded-xl p-4 py-2 flex items-center
            hover:bg-white/30 hover:border-white/50 hover:shadow-2xl hover:-translate-y-1 
            transition-all duration-200 ease-in-out">

            <!-- Profile Circle with Initials -->
            <div class="flex-shrink-0 w-14 h-14 rounded-full bg-blue-800 flex items-center justify-center text-white text-lg font-bold mr-4">
                ${getInitials(user.fullname)}
            </div>

            <!-- User Info -->
            <div class="flex-1 space-y-1">
                <p class="font-bold text-white text-lg">${escapeHtml(user.fullname)}</p>
                <p class="text-sm text-white/80">
                    ${escapeHtml(user.email)} | ${escapeHtml(user.username)} | ${escapeHtml(user.birthday)}
                </p>
                <p class="text-xs text-white/60">Registered at: ${escapeHtml(user.created_at)}</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-2">
                <button
                    class="editBtn bg-gradient-to-br from-green-600 to-green-800 text-white font-semibold py-2 px-4 rounded-lg shadow"
                    data-id="${user.id}"
                    data-fullname="${escapeHtml(user.fullname)}"
                    data-email="${escapeHtml(user.email)}"
                    data-username="${escapeHtml(user.username)}"
                    data-birthday="${user.birthday}">Edit</button>
                <button
                    class="deleteBtn bg-gradient-to-br from-red-500 to-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow"
                    data-id="${user.id}">Delete</button>
            </div>
        </li>
    `).join('');

    
    attachEventListeners();
}

// Utility function to escape HTML 
function escapeHtml(unsafe) {
    if (unsafe === null || unsafe === undefined) return '';
    return unsafe.toString()
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

// Attach event listeners to dynamically created elements
function attachEventListeners() {
    // Edit button handlers
    document.querySelectorAll('.editBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('editId').value = btn.dataset.id;
            document.getElementById('editFullname').value = btn.dataset.fullname;
            document.getElementById('editEmail').value = btn.dataset.email;
            document.getElementById('editUsername').value = btn.dataset.username;
            document.getElementById('editBirthday').value = btn.dataset.birthday;
            document.getElementById('editModal').classList.add('active');
        });
    });

    // Delete button handlers
    document.querySelectorAll('.deleteBtn').forEach(btn => {
        btn.addEventListener('click', async () => {
            if (!confirm('Are you sure to delete this user?')) return;
            
            const id = btn.dataset.id;
            try {
                const formData = new FormData();
                formData.append('action', 'delete');
                formData.append('id', id);
                
                const res = await axios.post('api.php', formData);
                if (res.data.status === 'success') {
                    alert(res.data.message);
                    await loadUsers(); 
                } else {
                    alert('Error: ' + (res.data.message || 'Unknown error occurred'));
                }
            } catch (error) {
                console.error('Error deleting user:', error);
                alert('Error deleting user. Please check console for details.');
            }
        });
    });
}

// Modal functions
function closeModal() {
    document.getElementById('editModal').classList.remove('active');
}

// Edit form submission
document.getElementById('editForm').addEventListener('submit', async e => {
    e.preventDefault();
    
    const id = document.getElementById('editId').value;
    const formData = new FormData();
    formData.append('action', 'edit');
    formData.append('id', id);
    formData.append('fullname', document.getElementById('editFullname').value);
    formData.append('email', document.getElementById('editEmail').value);
    formData.append('username', document.getElementById('editUsername').value);
    formData.append('birthday', document.getElementById('editBirthday').value);

    try {
        const res = await axios.post('api.php', formData);
        if (res.data.status === 'success') {
            alert(res.data.message);
            await loadUsers(); 
            closeModal();
        } else {
            alert('Error: ' + (res.data.message || 'Unknown error occurred'));
        }
    } catch (error) {
        console.error('Error updating user:', error);
        alert('Error updating user. Please check console for details.');
    }
});

// Close modal when clicking outside
document.getElementById('editModal').addEventListener('click', (e) => {
    if (e.target.id === 'editModal') {
        closeModal();
    }
});

// Load users when page loads
document.addEventListener('DOMContentLoaded', loadUsers);