function createTable(dataArray, dataAll) {
    // Create the main container div
    const container = document.getElementById("myTable");
    container.innerHTML = "";
    const paginationTop = createPagination(dataAll);
    container.appendChild(paginationTop);
    const table = document.createElement("table");
    table.classList.add("table");

    // Create table header
    const thead = document.createElement("thead");
    const headerRow = document.createElement("tr");

    const thNama = document.createElement("th");
    thNama.textContent = "Nama";

    const thPegawai = document.createElement("th");
    thPegawai.textContent = "Pegawai";

    const thWaktuPerjanjian = document.createElement("th");
    thWaktuPerjanjian.textContent = "Waktu Perjanjian";

    const thWaktuKedatangan = document.createElement("th");
    thWaktuKedatangan.textContent = "Waktu Kedatangan";

    const thStatus = document.createElement("th");
    thStatus.textContent = "Status";
    thStatus.colSpan = 2;

    const thDetail = document.createElement("th");
    thDetail.textContent = "Detail";

    // Append header cells to header row
    headerRow.appendChild(thNama);
    headerRow.appendChild(thPegawai);
    headerRow.appendChild(thWaktuPerjanjian);
    headerRow.appendChild(thWaktuKedatangan);
    headerRow.appendChild(thStatus);
    headerRow.appendChild(thDetail);

    // Append header row to thead
    thead.appendChild(headerRow);

    // Append thead to table
    table.appendChild(thead);

    // Create table body
    const tbody = document.createElement("tbody");

    // Iterate over data array to create table rows
    dataArray.forEach((data) => {
        const tr = document.createElement("tr");

        const tdNama = document.createElement("td");
        tdNama.textContent = data.nama;

        const tdPegawai = document.createElement("td");
        tdPegawai.textContent = data.pegawai.nama;

        const tdWaktuPerjanjian = document.createElement("td");
        tdWaktuPerjanjian.textContent = data.waktu_perjanjian;

        const tdWaktuKedatangan = document.createElement("td");
        tdWaktuKedatangan.textContent =
            data.waktu_kedatangan === null ? "-" : data.waktu_kedatangan;

        const tdStatus1 = document.createElement("td");
        const tdStatus2 = document.createElement("td");

        // Create status buttons or text
        if (data.status === "menunggu") {
            const acceptButton = document.createElement("a");
            acceptButton.href = route("terimaTamu", data.id);

            const acceptBtn = document.createElement("button");
            acceptBtn.classList.add("btn", "btn-success");
            acceptBtn.textContent = "Terima";

            acceptButton.appendChild(acceptBtn);
            tdStatus1.appendChild(acceptButton);

            const rejectButton = document.createElement("a");
            rejectButton.href = route("tolakTamu", data.id);

            const rejectBtn = document.createElement("button");
            rejectBtn.classList.add("btn", "btn-danger");
            rejectBtn.textContent = "Tolak";

            rejectButton.appendChild(rejectBtn);
            tdStatus2.appendChild(rejectButton);
        } else if (data.status === "diterima") {
            const addArrivalButton = document.createElement("a");
            addArrivalButton.href = route("tambahKedatanganTamu", data.id);

            const addArrivalBtn = document.createElement("button");
            addArrivalBtn.classList.add("btn", "btn-primary");
            addArrivalBtn.textContent = "Tambahkan Waktu Kedatangan";

            addArrivalButton.appendChild(addArrivalBtn);
            tdStatus1.appendChild(addArrivalButton);

            const noShowButton = document.createElement("a");
            noShowButton.href = route("tamuGagal", data.id);

            const noShowBtn = document.createElement("button");
            noShowBtn.classList.add("btn", "btn-danger");
            noShowBtn.textContent = "Tamu Tidak Datang";

            noShowButton.appendChild(noShowBtn);
            tdStatus2.appendChild(noShowButton);
        } else if (data.status === "selesai") {
            tdStatus1.classList.add("text-success");
            tdStatus1.colSpan = 2;
            tdStatus1.textContent = "Selesai";
        } else if (data.status === "ditolak") {
            tdStatus1.classList.add("text-danger");
            tdStatus1.colSpan = 2;
            tdStatus1.textContent = "Ditolak";
        } else if (data.status === "tidakDatang") {
            tdStatus1.classList.add("text-danger");
            tdStatus1.colSpan = 2;
            tdStatus1.textContent = "Tidak Datang";
        }

        // Detail button and modal
        const tdDetail = document.createElement("td");
        const detailButton = document.createElement("button");
        detailButton.type = "button";
        detailButton.classList.add("btn");
        detailButton.dataset.bsToggle = "modal";
        detailButton.dataset.bsTarget = `#detail${data.id}Modal`;

        const detailImg = document.createElement("img");
        detailImg.src = assetPath("img/detail.png");
        detailImg.alt = "detail";

        detailButton.appendChild(detailImg);
        tdDetail.appendChild(detailButton);

        // Create modal
        const modal = document.createElement("div");
        modal.classList.add("modal", "fade");
        modal.id = `detail${data.id}Modal`;
        modal.tabIndex = -1;
        modal.setAttribute("aria-labelledby", `detail${data.id}Modal`);
        modal.setAttribute("aria-hidden", "true");

        const modalDialog = document.createElement("div");
        modalDialog.classList.add("modal-dialog");

        const modalContent = document.createElement("div");
        modalContent.classList.add("modal-content");

        const modalHeader = document.createElement("div");
        modalHeader.classList.add("modal-header");

        const modalTitle = document.createElement("h1");
        modalTitle.classList.add("modal-title", "fs-5");
        modalTitle.id = `detail${data.id}Label`;
        modalTitle.textContent = "Detail";

        const closeButton = document.createElement("button");
        closeButton.type = "button";
        closeButton.classList.add("btn-close");
        closeButton.dataset.bsDismiss = "modal";
        closeButton.setAttribute("aria-label", "Close");

        modalHeader.appendChild(modalTitle);
        modalHeader.appendChild(closeButton);

        const modalBody = document.createElement("div");
        modalBody.classList.add("modal-body");

        const namaTamu = document.createElement("p");
        namaTamu.textContent = `Nama Tamu: ${data.nama}`;

        const bertemuDengan = document.createElement("p");
        bertemuDengan.textContent = `Bertemu Dengan: ${data.pegawai.nama}`;

        const waktuPertemuan = document.createElement("p");
        waktuPertemuan.textContent = `Waktu Pertemuan: ${data.waktu_kedatangan}`;

        const formKeterangan = document.createElement("form");
        formKeterangan.id = "formKeterangan";
        formKeterangan.action = route("ubahKeteranganTamu");
        formKeterangan.method = "post";

        const keteranganLabel = document.createElement("label");
        keteranganLabel.setAttribute("for", "keterangan");
        keteranganLabel.textContent = "Keterangan:";

        const keteranganTextarea = document.createElement("textarea");
        keteranganTextarea.name = "keterangan";
        keteranganTextarea.id = "keterangan";
        keteranganTextarea.cols = 30;
        keteranganTextarea.rows = 10;
        keteranganTextarea.classList.add("form-control");
        keteranganTextarea.textContent = data.keterangan;

        const inputHidden = document.createElement("input");
        inputHidden.type = "hidden";
        inputHidden.name = "id";
        inputHidden.value = data.id;

        formKeterangan.appendChild(keteranganLabel);
        formKeterangan.appendChild(keteranganTextarea);
        formKeterangan.appendChild(inputHidden);

        modalBody.appendChild(namaTamu);
        modalBody.appendChild(bertemuDengan);
        modalBody.appendChild(waktuPertemuan);
        modalBody.appendChild(formKeterangan);

        if (data.foto !== null) {
            const fotoImg = document.createElement("img");
            fotoImg.src = assetPath(`img/tamu/${data.foto}`);
            fotoImg.alt = "Foto Tamu";

            modalBody.appendChild(fotoImg);
        }

        const modalFooter = document.createElement("div");
        modalFooter.classList.add("modal-footer");

        const closeModalButton = document.createElement("button");
        closeModalButton.type = "button";
        closeModalButton.classList.add("btn", "btn-secondary");
        closeModalButton.dataset.bsDismiss = "modal";
        closeModalButton.textContent = "Close";

        const saveButton = document.createElement("button");
        saveButton.type = "button";
        saveButton.classList.add("btn", "btn-primary");
        saveButton.textContent = "Simpan Keterangan";
        saveButton.onclick = () => {
            document.getElementById("formKeterangan").submit();
        };

        modalFooter.appendChild(closeModalButton);
        modalFooter.appendChild(saveButton);

        modalContent.appendChild(modalHeader);
        modalContent.appendChild(modalBody);
        modalContent.appendChild(modalFooter);

        modalDialog.appendChild(modalContent);
        modal.appendChild(modalDialog);

        tdDetail.appendChild(modal);

        // Append cells to row
        tr.appendChild(tdNama);
        tr.appendChild(tdPegawai);
        tr.appendChild(tdWaktuPerjanjian);
        tr.appendChild(tdWaktuKedatangan);
        tr.appendChild(tdStatus1);
        tr.appendChild(tdStatus2);
        tr.appendChild(tdDetail);

        // Append row to tbody
        tbody.appendChild(tr);
    });

    // Append tbody to table
    table.appendChild(tbody);

    // Append table to main container
    container.appendChild(table);

    // Pagination bottom
    const paginationBottom = createPagination(dataAll);

    // Append pagination bottom to main container
    container.appendChild(paginationBottom);
}

// Helper function to create pagination
function createPagination(dataAll) {
    const pagination = document.createElement("div");
    pagination.classList.add("d-flex", "justify-content-center");

    // Create pagination links (for demonstration purposes)
    const paginationLinks = document.createElement("nav");
    paginationLinks.setAttribute("aria-label", "Page navigation example");

    const ul = document.createElement("ul");
    ul.setAttribute("class", "pagination");
    console.log(dataAll);
    // ul.appendChild(linkPrev);
    if (dataAll.links.length < 10) {
        dataAll.links.forEach((element, i) => {
            const current = document.createElement("li");
            const currentDiv = document.createElement("div");
            currentDiv.classList.add("page-link");
            currentDiv.innerHTML = element.label;
            current.appendChild(currentDiv);
            current.classList.add("page-item");
            if (element.active) {
                current.classList.add("active");
            }
            if (element.url != null) {
                current.addEventListener("click", () => {
                    searchPag(element.url);
                });
            }
            if (i == 0 && dataAll.prev_page_url == null) {
                current.classList.add("disabled");
            }
            if (
                i == dataAll.links.length - 1 &&
                dataAll.next_page_url == null
            ) {
                current.classList.add("disabled");
            }
            ul.appendChild(current);
        });
    } else {
        console.log("ola");
        const prev = document.createElement("li");
        const prevDiv = document.createElement("div");
        prevDiv.classList.add("page-link");
        prevDiv.innerHTML = dataAll.links[0].label;
        prev.appendChild(prevDiv);
        prev.classList.add("page-item");
        if (dataAll.prev_page_url != null) {
            prev.addEventListener("click", () => {
                searchPag(dataAll.prev_page_url);
            });
        } else {
            prev.classList.add("disabled");
        }
        ul.appendChild(prev);

        dataAll.links.forEach((element, i) => {
            if (!(i == 0 || i == dataAll.links.length - 1)) {
                const current = document.createElement("li");
                const currentDiv = document.createElement("div");
                currentDiv.classList.add("page-link");
                currentDiv.innerHTML = element.label;
                current.appendChild(currentDiv);
                current.classList.add("page-item");
                current.addEventListener("click", () => {
                    searchPag(element.url);
                });
                if (element.active) {
                    current.classList.add("active");
                }
                ul.appendChild(current);
            }
        });

        const next = document.createElement("li");
        const nextDiv = document.createElement("div");
        nextDiv.classList.add("page-link");
        nextDiv.innerHTML = dataAll.links[dataAll.links.length - 1].label;
        next.appendChild(nextDiv);
        next.classList.add("page-item");
        if (dataAll.next_page_url != null) {
            next.addEventListener("click", () => {
                searchPag(dataAll.next_page_url);
            });
        } else {
            next.classList.add("disabled");
        }
        ul.appendChild(next);
    }
    // ul.appendChild(linkNext);
    paginationLinks.appendChild(ul);

    pagination.appendChild(paginationLinks);
    return pagination;
}

// Example asset path function (similar to Laravel's asset() helper)
function assetPath(path) {
    return `/${path}`; // Update with your asset path
}

// Example route function (similar to Laravel's route() helper)
function route(name, id) {
    const routes = {
        terimaTamu: `/tamu/terima/${id}`,
        tolakTamu: `/tamu/tolak/${id}`,
        tambahKedatanganTamu: `/tamu/kedatangan/${id}`,
        tamuGagal: `/tamu/gagal/${id}`,
        ubahKeteranganTamu: `/keterangan`,
    };
    return routes[name];
}

// Example usage with data
const dataTable = {};

// Function to convert an object to a query string

async function search() {
    const dataToSend = {
        search: document.getElementById("search_2").value,
        status: document.getElementById("status").value,
    };
    const apiUrl = `/kunjungan`;
    try {
        // Send a POST request to the API
        const response = await fetch(apiUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"), // CSRF token for Laravel
            },
            body: JSON.stringify(dataToSend),
        });

        // Check if the response is OK (status 200-299)
        if (!response.ok) {
            throw new Error(
                "Network response was not ok " + response.statusText
            );
        }
        const responseText = await response.text();
        // console.log("Raw response text:", responseText);

        // Try parsing the response as JSON
        const data = JSON.parse(responseText);

        // Set the data to a variable
        const myDataVariable = data.data.data;

        // Here you can manipulate the data or use it to update the UI
        createTable(myDataVariable, data.data);
    } catch (error) {
        // Handle any errors that occurred during the fetch
        console.error("Error sending data:", error);
    }
}

async function searchPag(apiUrl) {
    const dataToSend = {
        search: document.getElementById("search_2").value,
        status: document.getElementById("status").value,
    };
    try {
        // Send a POST request to the API
        const response = await fetch(apiUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"), // CSRF token for Laravel
            },
            body: JSON.stringify(dataToSend),
        });

        // Check if the response is OK (status 200-299)
        if (!response.ok) {
            throw new Error(
                "Network response was not ok " + response.statusText
            );
        }
        const responseText = await response.text();
        // console.log("Raw response text:", responseText);

        // Try parsing the response as JSON
        const data = JSON.parse(responseText);

        // Set the data to a variable
        const myDataVariable = data.data.data;

        // Here you can manipulate the data or use it to update the UI
        createTable(myDataVariable, data.data);
    } catch (error) {
        // Handle any errors that occurred during the fetch
        console.error("Error sending data:", error);
    }
}

// Example data to send

// Call search function to send data
