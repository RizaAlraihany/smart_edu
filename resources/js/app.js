import "./bootstrap";
import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";

Alpine.plugin(collapse);

window.Alpine = Alpine;

Alpine.start();

// Smart Education App specific JavaScript
document.addEventListener("DOMContentLoaded", function () {
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById("mobile-menu-button");
    const mobileMenu = document.getElementById("mobile-menu");

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener("click", function () {
            mobileMenu.classList.toggle("hidden");
        });
    }

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('[role="alert"]');
    alerts.forEach((alert) => {
        setTimeout(() => {
            alert.style.opacity = "0";
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });

    // Confirm delete dialogs
    const deleteButtons = document.querySelectorAll("[data-confirm-delete]");
    deleteButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            if (!confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                e.preventDefault();
            }
        });
    });
});
