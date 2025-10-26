<!-- Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 dark:bg-black dark:bg-opacity-70 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full animate-slide-up">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-heading font-semibold text-secondary-900 dark:text-primary-400-dark" id="modalTitle">Xác nhận</h3>
                        <p class="text-secondary-500 dark:text-gray-300 text-sm mt-1">Thao tác này không thể hoàn tác</p>
                    </div>
                </div>

                <p class="text-secondary-700 dark:text-gray-300 mb-6" id="modalMessage">
                    Bạn có chắc chắn muốn thực hiện hành động này không?
                </p>

                <div class="flex space-x-3">
                    <button type="button" onclick="closeConfirmationModal()" class="btn-secondary flex-1">
                        Hủy
                    </button>
                    <button type="button" onclick="confirmAction()" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-red-400 dark:focus:ring-offset-gray-800 transition-all duration-200" id="confirmButton">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Xác nhận
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let confirmationCallback = null;

window.showConfirmationModal = function(title, message, confirmText, callback) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalMessage').textContent = message;
    document.getElementById('confirmButton').innerHTML = `
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
        ${confirmText}
    `;
    confirmationCallback = callback;
    document.getElementById('confirmationModal').classList.remove('hidden');
};

window.closeConfirmationModal = function() {
    document.getElementById('confirmationModal').classList.add('hidden');
    confirmationCallback = null;
};

window.confirmAction = function() {
    if (confirmationCallback) {
        confirmationCallback();
    }
    closeConfirmationModal();
};

document.getElementById('confirmationModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeConfirmationModal();
    }
});
</script>