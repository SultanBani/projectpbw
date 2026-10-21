"use strict";

document.addEventListener("DOMContentLoaded", () => {
    const gambarUtama = document.getElementById("gambarUtama");
    const thumbnails = [...document.querySelectorAll(".thumbnail img")];
    const dots = document.querySelector(".galeri-dots");
    const sebelum = document.querySelector(".galeri-sebelum");
    const sesudah = document.querySelector(".galeri-sesudah");
    const hero = document.querySelector(".galeri-hero");
    if (!gambarUtama || thumbnails.length === 0) return;

    let aktif = 0;
    let autoplayTimer;
    let pergantianTimer;
    let sedangDisorot = false;
    const durasi = 5000;

    function tampilkan(index) {
        aktif = (index + thumbnails.length) % thumbnails.length;
        const gambar = thumbnails[aktif];
        window.clearTimeout(pergantianTimer);
        gambarUtama.classList.add("berganti");
        pergantianTimer = window.setTimeout(() => {
            gambarUtama.src = gambar.src;
            gambarUtama.alt = gambar.alt;
            gambarUtama.classList.remove("berganti");
        }, 150);
        thumbnails.forEach((item, nomor) => item.classList.toggle("aktif", nomor === aktif));
        [...dots.children].forEach((item, nomor) => item.classList.toggle("aktif", nomor === aktif));
    }

    function hentikanOtomatis() {
        window.clearTimeout(autoplayTimer);
        autoplayTimer = undefined;
    }

    function jadwalkanOtomatis() {
        hentikanOtomatis();
        if (sedangDisorot) return;
        autoplayTimer = window.setTimeout(() => {
            tampilkan(aktif + 1);
            jadwalkanOtomatis();
        }, durasi);
    }

    function pilihManual(index) {
        tampilkan(index);
        jadwalkanOtomatis();
    }

    thumbnails.forEach((gambar, index) => {
        gambar.addEventListener("click", () => pilihManual(index));
        const dot = document.createElement("button");
        dot.type = "button";
        dot.className = "galeri-dot";
        dot.setAttribute("aria-label", `Tampilkan gambar ${index + 1}`);
        dot.addEventListener("click", () => pilihManual(index));
        dots?.appendChild(dot);
    });
    sebelum?.addEventListener("click", () => pilihManual(aktif - 1));
    sesudah?.addEventListener("click", () => pilihManual(aktif + 1));
    hero?.addEventListener("mouseenter", () => {
        sedangDisorot = true;
        hentikanOtomatis();
    });
    hero?.addEventListener("mouseleave", () => {
        sedangDisorot = false;
        jadwalkanOtomatis();
    });
    gambarUtama.addEventListener("error", () => {
        gambarUtama.alt = "Gambar kegiatan tidak tersedia";
        gambarUtama.removeAttribute("src");
    }, { once: true });
    tampilkan(0);
    jadwalkanOtomatis();
});
