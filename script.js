document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");
    if (form) {
        form.addEventListener("submit", () => {
            const btn = form.querySelector("button");
            if (btn) {
                btn.disabled = true;
                btn.textContent = "Enviando...";
            }
        });
    }
});
