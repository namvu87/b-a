/**
 * Đại Long Foods - Warehouse Management System
 * Main JavaScript File
 */

$(document).ready(function() {
    console.log('WMS Đại Long Foods initialized!');
    
    // Toggle menu
    $('.menu-title').on('click', function() {
        $(this).parent().toggleClass('active');
    });
    
    // Close modal on overlay click
    $(document).on('click', '.modal-overlay', function(e) {
        if (e.target === this) {
            $(this).removeClass('active');
        }
    });
    
    // Close modal on close button
    $(document).on('click', '.modal-close, .btn-cancel', function() {
        $(this).closest('.modal-overlay').removeClass('active');
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
});

// Modal functions
function openModal(modalId) {
    $('#' + modalId).addClass('active');
}

function closeModal(modalId) {
    $('#' + modalId).removeClass('active');
}

// Export helper
function exportToExcel(url) {
    window.location.href = url;
}
