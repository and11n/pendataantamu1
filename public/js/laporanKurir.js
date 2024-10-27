// Function to create and populate the table dynamically

// Function to create and populate the table dynamically
function createTableKurir(dataArray, dataAll) {
    // Create the table and its components
    const container = document.getElementById("myTable");
    container.innerHTML = "";

    const topPagination = createPagination(dataAll);
    container.appendChild(topPagination);

    const table = document.createElement("table");
    table.className = "table";

    const thead = document.createElement("thead");
    const trHead = document.createElement("tr");

    // Define table headers
    const headers = [
        "Nama Kurir",
        "Nama Perusahaan Ekspedisi",
        "Pegawai Penerima",
        "Tanggal & Waktu",
        "Detail",
    ];

    // Append headers to the thead
    headers.forEach((headerText) => {
        const th = document.createElement("th");
        th.textContent = headerText;
        trHead.appendChild(th);
    });

    thead.appendChild(trHead);
    table.appendChild(thead);

    const tbody = document.createElement("tbody");

    // Populate the table body with data rows
    dataArray.forEach((data) => {
        const tr = document.createElement("tr");

        // Create and append each cell in the row
        const tdNamaKurir = document.createElement("td");
        tdNamaKurir.textContent = data.nama_kurir;
        tr.appendChild(tdNamaKurir);

        const tdEkspedisi = document.createElement("td");
        tdEkspedisi.textContent = data.ekspedisi.nama;
        tr.appendChild(tdEkspedisi);

        const tdPegawai = document.createElement("td");
        tdPegawai.textContent = data.pegawai.nama;
        tr.appendChild(tdPegawai);

        const tdTanggal = document.createElement("td");
        tdTanggal.textContent = data.created_at;
        tr.appendChild(tdTanggal);

        const tdDetail = document.createElement("td");
        const detailButton = document.createElement("button");
        detailButton.className = "btn";
        detailButton.type = "button";
        detailButton.setAttribute("data-bs-toggle", "modal");
        detailButton.setAttribute("data-bs-target", `#detail${data.id}`);
        const detailImg = document.createElement("img");
        detailImg.src = "/img/detail.png";
        detailImg.alt = "detail";
        detailButton.appendChild(detailImg);
        tdDetail.appendChild(detailButton);

        // Create and append modal
        const modalDiv = document.createElement("div");
        modalDiv.className = "modal fade";
        modalDiv.id = `detail${data.id}`;
        modalDiv.setAttribute("tabindex", "-1");
        modalDiv.setAttribute("aria-labelledby", `detail${data.id}Label`);
        modalDiv.setAttribute("aria-hidden", "true");

        const modalDialog = document.createElement("div");
        modalDialog.className = "modal-dialog";

        const modalContent = document.createElement("div");
        modalContent.className = "modal-content";

        const modalHeader = document.createElement("div");
        modalHeader.className = "modal-header";

        const modalTitle = document.createElement("h1");
        modalTitle.className = "modal-title fs-5";
        modalTitle.id = `detail${data.id}Label`;
        modalTitle.textContent = "Detail Pengiriman";

        const closeButton = document.createElement("button");
        closeButton.type = "button";
        closeButton.className = "btn-close";
        closeButton.setAttribute("data-bs-dismiss", "modal");
        closeButton.setAttribute("aria-label", "Close");

        modalHeader.appendChild(modalTitle);
        modalHeader.appendChild(closeButton);

        const modalBody = document.createElement("div");
        modalBody.className = "modal-body";

        const detailNamaKurir = document.createElement("p");
        detailNamaKurir.textContent = `Nama Kurir: ${data.nama_kurir}`;

        const detailPenerima = document.createElement("p");
        detailPenerima.textContent = `Penerima: ${data.pegawai.nama}`;

        const detailEkspedisi = document.createElement("p");
        detailEkspedisi.textContent = `Perusahaan Ekspedisi: ${data.ekspedisi.nama}`;

        modalBody.appendChild(detailNamaKurir);
        modalBody.appendChild(detailPenerima);
        modalBody.appendChild(detailEkspedisi);

        if (data.foto) {
            const fotoImg = document.createElement("img");
            fotoImg.src = `/img/tamu/${data.foto}`;
            fotoImg.alt = "Foto Kurir";
            modalBody.appendChild(fotoImg);
        }

        const modalFooter = document.createElement("div");
        modalFooter.className = "modal-footer";

        const closeButtonFooter = document.createElement("button");
        closeButtonFooter.type = "button";
        closeButtonFooter.className = "btn btn-secondary";
        closeButtonFooter.setAttribute("data-bs-dismiss", "modal");
        closeButtonFooter.textContent = "Close";

        const saveButton = document.createElement("button");
        saveButton.type = "button";
        saveButton.className = "btn btn-primary";
        saveButton.textContent = "Simpan Keterangan";
        saveButton.addEventListener("click", () => {
            // Logic for saving the details can be added here
            console.log(`Saving details for ${data.nama_kurir}`);
        });

        modalFooter.appendChild(closeButtonFooter);
        modalFooter.appendChild(saveButton);

        modalContent.appendChild(modalHeader);
        modalContent.appendChild(modalBody);
        modalContent.appendChild(modalFooter);

        modalDialog.appendChild(modalContent);
        modalDiv.appendChild(modalDialog);

        tdDetail.appendChild(modalDiv);
        tr.appendChild(tdDetail);

        tbody.appendChild(tr);
    });

    table.appendChild(tbody);

    // Append the table to the desired container in the DOM
    // Clear existing contents if any
    container.appendChild(table);
    const downPagination = createPagination(dataAll);
    container.appendChild(downPagination);
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

// Function to convert an object to a query string

async function search() {
    const dataToSend = {
        search: document.getElementById("search_2").value,
        entry: document.getElementById("entries").value,
        lama: document.getElementById("lama").value,
    };

    const apiUrl = `/laporan/kurir`;
    try {
        const response = await fetch(apiUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify(dataToSend),
        });

        const responseText = await response.text();
        console.log("Response:", responseText);

        const data = JSON.parse(responseText);
        console.log("Parsed data:", data);

        // Pastikan data formatnya sesuai dengan yang diharapkan
        const myDataVariable = data.datas.data;
        createTableKurir(myDataVariable, data.datas);
    } catch (error) {
        console.error("Error sending data:", error);
    }
}
console.log('Response text:', responseText);

async function searchPag(apiUrl) {
    const dataToSend = {
        search: document.getElementById("search_2").value,
        entry: document.getElementById("entries").value,
        lama: document.getElementById("lama").value,
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
        const myDataVariable = data.datas.data;

        // Here you can manipulate the data or use it to update the UI
        createTableKurir(myDataVariable, data.datas);
    } catch (error) {
        // Handle any errors that occurred during the fetch
        console.error("Error sending data:", error);
    }
}

// Example data to send

// Call search function to send data
