document.addEventListener('DOMContentLoaded', function() {
    // Get all modal elements
    const editProfileModal = document.getElementById('editProfileModal');
    const changePasswordModal = document.getElementById('changePasswordModal');
    const avatarModal = document.getElementById('avatarModal');
    const deleteAccountModal = document.getElementById('deleteAccountModal');
    const closeButtons = document.getElementsByClassName('close');

    // Get all buttons
    const editProfileBtn = document.querySelector('.edit-profile-btn');
    const changePasswordBtn = document.querySelector('.change-password-btn');
    const changeAvatarBtn = document.querySelector('.change-avatar-btn');
    const deleteAccountBtn = document.querySelector('.delete-account-btn');

    // Open modals
    editProfileBtn.onclick = () => editProfileModal.style.display = "block";
    changePasswordBtn.onclick = () => changePasswordModal.style.display = "block";
    changeAvatarBtn.onclick = () => avatarModal.style.display = "block";
    deleteAccountBtn.onclick = () => deleteAccountModal.style.display = "block";

    // Close modals
    Array.from(closeButtons).forEach(button => {
        button.onclick = function() {
            editProfileModal.style.display = "none";
            changePasswordModal.style.display = "none";
            avatarModal.style.display = "none";
            deleteAccountModal.style.display = "none";
        }
    });

    // Close when clicking outside
    window.onclick = function(event) {
        if ([editProfileModal, changePasswordModal, avatarModal, deleteAccountModal].includes(event.target)) {
            event.target.style.display = "none";
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

    // Avatar preview
    const avatarInput = document.querySelector('input[name="avatar"]');
    if (avatarInput) {
        avatarInput.onchange = function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                // Check file size
                if (file.size > 5 * 1024 * 1024) { // 5MB
                    alert('File is too large. Maximum size is 5MB.');
                    this.value = '';
                    return;
                }
                // Check file type
                if (!file.type.match(/image.*/)) {
                    alert('Please upload an image file.');
                    this.value = '';
                    return;
                }
            }
        }
    }

    // Delete account confirmation
    const deleteAccountForm = document.getElementById('deleteAccountForm');
    if (deleteAccountForm) {
        deleteAccountForm.onsubmit = function(e) {
            if (!confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
                e.preventDefault();
                return false;
            }
        }
    }
});
