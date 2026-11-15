function showSection(section, title, button) {
    document.getElementById("TransaksiMasukSection").classList.add("hidden");
    document.getElementById("detailTransaksiSection").classList.add("hidden");

    document.getElementById(section).classList.remove("hidden");

    document.getElementById("pageTitle").innerText = title;

    document.querySelectorAll(".tab-btn").forEach((btn) => {
        btn.classList.remove("border-black", "text-black");
        btn.classList.add("border-transparent", "text-gray-500");
    });

    button.classList.remove("border-transparent", "text-gray-500");
    button.classList.add("border-black", "text-black");
}
