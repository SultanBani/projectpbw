"use strict";

document.addEventListener("DOMContentLoaded", () => {
    const dialog = document.getElementById("dialogLogout");
    const formLogout = document.getElementById("formLogout");
    const tombolKonfirmasi = document.getElementById("konfirmasiLogout");
    document.querySelectorAll("[data-logout-trigger]").forEach((pemicu) => {
        pemicu.addEventListener("click", (event) => {
            event.preventDefault();
            if (typeof dialog.showModal === "function") {
                dialog.showModal();
            }
        });
    });
    tombolKonfirmasi?.addEventListener("click", () => formLogout?.requestSubmit());
});
