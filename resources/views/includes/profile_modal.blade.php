<div id="profileModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeProfileModal()">&times;</span>
        <div class="profile-info">
            <img id="profilePicture" src="{{ session('profile_picture', asset('assets/default-profile.png')) }}"
                alt="Profile Picture" />
            <h2 id="profileName">{{ session('username', 'Guest') }}</h2>
            <p id="profileEmail">Email: {{ session('email', 'N/A') }}</p>
            <p id="profileRole">Role: {{ session('role', 'User') }}</p>
            <div class="profile-actions">
                <button onclick="editProfile()">Edit Profile</button>
                <button onclick="viewDetails()">View Details</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showProfileModal() {
        document.getElementById('profileModal').style.display = 'block';
    }

    function closeProfileModal() {
        document.getElementById('profileModal').style.display = 'none';
    }

    function editProfile() {
        alert('Edit Profile functionality is under development.');
    }

    function viewDetails() {
        alert('View Details functionality is under development.');
    }
</script>


<style>
    /* Modal Overlay */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        transition: opacity 0.3s ease;
    }

    /* Modal Content */
    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 30px;
        width: 450px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        position: relative;
        animation: slideDown 0.3s ease-in-out;
    }

    @keyframes slideDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Profile Picture */
    .profile-info img {
        border-radius: 50%;
        width: 150px;
        height: 150px;
        margin-bottom: 20px;
        /* border: 5px solid #007BFF; */
    }

    /* Profile Name */
    .profile-info h2 {
        font-size: 24px;
        margin: 15px 0;
        color: #333;
        font-weight: 600;
    }

    /* Profile Information (Email, Role) */
    .profile-info p {
        font-size: 16px;
        color: #555;
        margin: 5px 0;
    }

    /* Profile Actions */
    .profile-actions {
        margin-top: 20px;
    }

    .profile-actions button {
        margin: 5px;
        padding: 12px 25px;
        border: none;
        background-color: #007BFF;
        color: white;
        cursor: pointer;
        border-radius: 5px;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .profile-actions button:hover {
        background-color: #0056b3;
    }

    /* Close Button */
    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 30px;
        font-weight: bold;
        color: #333;
        background-color: transparent;
        border: none;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .close:hover {
        color: #007BFF;
    }

    .close:focus {
        outline: none;
    }

    /* Toast Container */
    .toast-container {
        position: fixed;
        top: 10px;
        right: 10px;
        z-index: 9999;
        max-width: 300px;
    }

    .toast {
        padding: 15px;
        border-radius: 5px;
        color: #fff;
        font-size: 16px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .toast.alert-success {
        background-color: #28a745;
    }

    .toast.alert-danger {
        background-color: #dc3545;
    }

    .toast .close {
        font-size: 20px;
        cursor: pointer;
    }
</style>
