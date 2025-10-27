import { Maximize2, Minimize2 } from "lucide";

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".trix-toolbar").forEach((toolbar) => {
        // Prevent duplicate button
        if (toolbar.querySelector(".trix-button--fullscreen")) return;

        // Create button
        const btn = document.createElement("button");
        btn.type = "button";
        btn.className = "trix-button trix-button--icon trix-button--fullscreen";
        btn.title = "Toggle Fullscreen";
        btn.setAttribute("aria-label", "Toggle Fullscreen");

        // Add icon
        const icon = Maximize2({ size: 16 });
        btn.appendChild(icon);

        // Add click toggle
        btn.addEventListener("click", () => {
            const wrapper = toolbar.closest(".filament-forms-rich-editor");
            const isFull = wrapper.classList.toggle("fullscreen-mode");
            btn.innerHTML = ""; // clear
            btn.appendChild(isFull ? Minimize2({ size: 16 }) : Maximize2({ size: 16 }));
        });

        toolbar.appendChild(btn);
    });
});
