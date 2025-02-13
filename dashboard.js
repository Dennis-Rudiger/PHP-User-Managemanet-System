document.addEventListener('DOMContentLoaded', function() {
    // Get modal elements
    const editProfileModal = document.getElementById('editProfileModal');
    const changePasswordModal = document.getElementById('changePasswordModal');
    const closeButtons = document.getElementsByClassName('close');

    // Get buttons
    const editProfileBtn = document.querySelector('.edit-profile-btn');
    const changePasswordBtn = document.querySelector('.change-password-btn');

    // Open modals
    editProfileBtn.onclick = function() {
        editProfileModal.style.display = "block";
    }

    changePasswordBtn.onclick = function() {
        changePasswordModal.style.display = "block";
    }

    // Close modals
    Array.from(closeButtons).forEach(button => {
        button.onclick = function() {
            editProfileModal.style.display = "none";
            changePasswordModal.style.display = "none";
        }
    });

    // Close when clicking outside
    window.onclick = function(event) {
        if (event.target == editProfileModal) {
            editProfileModal.style.display = "none";
        }
        if (event.target == changePasswordModal) {
            changePasswordModal.style.display = "none";
        }
    }

    // Form validation
    const changePasswordForm = document.getElementById('changePasswordForm');
    if (changePasswordForm) {
        changePasswordForm.onsubmit = function(e) {
            const newPass = this.new_password.value;
            const confirmPass = this.confirm_password.value;
            
            if (newPass !== confirmPass) {
                e.preventDefault();
                alert('New passwords do not match!');
                return false;
            }
            if (newPass.length < 6) {
                e.preventDefault();
                alert('Password must be at least 6 characters long!');
                return false;
            }
        }
    }
});
