<?php
include "db.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="user.css">
</head>

<body class="h-screen bg-cover bg-center bg-no-repeat overflow-hidden" style="background-image:url('assets/img1.jpg')">

    <div class="container flex flex-col items-center w-full max-w-3xl h-full">
        <h2 class="text-white text-center mb-3 mt-7 font-bold text-2xl pt-4">Registered Users</h2>
        <a href="index.php" class="back-link text-white self-start mb-3 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left pl-2"></i>
            <span>Back to Registration</span>
        </a>

        <!-- Users List -->
        <div class="w-full max-w-3xl overflow-hidden">
            <ul id="usersList" class="w-full space-y-4 px-2 overflow-y-auto h-[70vh]">
                <!-- Users will be loaded here via AJAX -->
            </ul>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal">
        <div class="modal-content">
            <h3 class="font-bold">Edit User Info</h3>
            <form id="editForm">
                <input type="hidden" id="editId">
                <label>Full Name
                    <input type="text" id="editFullname" required>
                </label>
                <label>Email
                    <input type="email" id="editEmail" required>
                </label>
                <label>Username
                    <input type="text" id="editUsername" required>
                </label>
                <label>Birthday
                    <input type="date" id="editBirthday" required>
                </label>
                <div class="btn-group flex justify-end gap-3 mt-4">
                    <button type="button" onclick="closeModal()"
                        class="bg-white/20 hover:bg-white/30 text-white py-2 px-4 rounded">Cancel</button>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.0/axios.min.js"></script>
    <script src="user.js"></script>
</body>

</html>