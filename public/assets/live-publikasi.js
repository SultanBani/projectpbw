"use strict";

document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("kataKunci");
    const tableBody = document.getElementById("isiPublikasi");
    const main = document.querySelector("main[data-api-url]");
    const status = document.getElementById("statusPencarian");
    const suggestions = document.getElementById("saranPublikasi");
    const token = document.querySelector('meta[name="csrf-token"]')?.content;

    if (!input || !tableBody || !main || !status || !suggestions || !token) return;

    let timer;
    let activeRequest;

    function addCell(row, value) {
        const cell = document.createElement("td");
        cell.textContent = value;
        row.appendChild(cell);
    }

    function createRow(publikasi) {
        const row = document.createElement("tr");
        const formattedDate = new Date(`${publikasi.tanggal_rilis}T00:00:00`).toLocaleDateString("id-ID", {
            day: "2-digit",
            month: "long",
            year: "numeric",
        });

        addCell(row, publikasi.no);
        addCell(row, publikasi.judul);
        addCell(row, formattedDate);

        const coverCell = document.createElement("td");
        const cover = document.createElement("img");
        cover.src = `${main.dataset.assetsUrl}/${encodeURIComponent(publikasi.sampul)}`;
        cover.alt = `Sampul ${publikasi.judul}`;
        cover.width = 70;
        cover.addEventListener("error", () => {
            cover.alt = "Sampul tidak tersedia";
            cover.removeAttribute("src");
        }, { once: true });
        coverCell.appendChild(cover);
        row.appendChild(coverCell);

        const actionCell = document.createElement("td");
        const edit = document.createElement("a");
        edit.href = main.dataset.editUrl.replace("__NO__", encodeURIComponent(publikasi.no));
        edit.textContent = "Edit";

        const deleteForm = document.createElement("form");
        deleteForm.className = "form-hapus";
        deleteForm.action = main.dataset.deleteUrl.replace("__NO__", encodeURIComponent(publikasi.no));
        deleteForm.method = "post";
        deleteForm.addEventListener("submit", (event) => {
            if (!window.confirm("Yakin ingin menghapus publikasi ini?")) event.preventDefault();
        });

        for (const [name, value] of [["_token", token], ["_method", "DELETE"]]) {
            const field = document.createElement("input");
            field.type = "hidden";
            field.name = name;
            field.value = value;
            deleteForm.appendChild(field);
        }

        const deleteButton = document.createElement("button");
        deleteButton.type = "submit";
        deleteButton.textContent = "Hapus";
        deleteForm.appendChild(deleteButton);

        actionCell.append(edit, " | ", deleteForm);
        row.appendChild(actionCell);
        return row;
    }

    function showSuggestions(items, keyword) {
        suggestions.replaceChildren();
        suggestions.hidden = keyword === "";
        if (keyword === "") return;

        const list = document.createElement("ul");
        items.slice(0, 7).forEach((item) => {
            const listItem = document.createElement("li");
            const button = document.createElement("button");
            button.type = "button";
            button.className = "saran-publikasi-item";
            button.textContent = item.judul;
            button.addEventListener("click", () => {
                input.value = item.judul;
                loadPublikasi();
                input.focus();
            });
            listItem.appendChild(button);
            list.appendChild(listItem);
        });

        if (items.length === 0) {
            const empty = document.createElement("p");
            empty.textContent = "Publikasi tidak ditemukan.";
            suggestions.appendChild(empty);
            return;
        }

        suggestions.appendChild(list);
    }

    async function loadPublikasi() {
        activeRequest?.abort();
        activeRequest = new AbortController();
        const keyword = input.value.trim();

        try {
            const response = await fetch(`${main.dataset.apiUrl}?q=${encodeURIComponent(keyword)}`, {
                headers: { Accept: "application/json" },
                signal: activeRequest.signal,
                cache: "no-store",
            });
            if (!response.ok) throw new Error("Gagal memuat publikasi");

            const payload = await response.json();
            const rows = document.createDocumentFragment();

            if (payload.data.length === 0) {
                const row = document.createElement("tr");
                const cell = document.createElement("td");
                cell.colSpan = 5;
                cell.textContent = keyword ? "Publikasi tidak ditemukan." : "Belum ada publikasi.";
                row.appendChild(cell);
                rows.appendChild(row);
            } else {
                payload.data.forEach((publikasi) => rows.appendChild(createRow(publikasi)));
            }

            tableBody.replaceChildren(rows);
            showSuggestions(payload.data, keyword);
            status.hidden = true;
            status.textContent = "";
        } catch (error) {
            if (error.name !== "AbortError") {
                status.hidden = false;
                status.textContent = "Data publikasi tidak dapat diperbarui. Silakan muat ulang halaman.";
            }
        }
    }

    input.addEventListener("input", () => {
        window.clearTimeout(timer);
        timer = window.setTimeout(loadPublikasi, 250);
    });
    window.setInterval(() => {
        if (!document.hidden) loadPublikasi();
    }, 15000);
    window.addEventListener("focus", loadPublikasi);
    loadPublikasi();
});
