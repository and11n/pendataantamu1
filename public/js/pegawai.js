// Function to create and populate the table dynamically
// Sample data to mimic Laravel's $data variable

// Main function to create the table
function createTable(data, dataAll) {
    const table = document.createElement("table");
    table.classList.add("table");

    // Create table head
    const thead = document.createElement("thead");
    const headerRow = document.createElement("tr");

    const headers = [
        "No.",
        "Nama",
        "No. Telp.",
        "PTK",
        "NIP",
        "Email",
        "Action",
    ];

    headers.forEach((headerText) => {
        const th = document.createElement("th");
        th.textContent = headerText;
        headerRow.appendChild(th);
    });

    thead.appendChild(headerRow);
    table.appendChild(thead);

    // Create table body
    const tbody = document.createElement("tbody");

    let no = 1;
    data.forEach((dat) => {
        const row = document.createElement("tr");

        // No
        const noCell = document.createElement("td");
        noCell.textContent = no++;
        row.appendChild(noCell);

        // Nama
        const namaCell = document.createElement("td");
        namaCell.textContent = dat.nama;
        row.appendChild(namaCell);

        // No. Telp.
        const noTelpCell = document.createElement("td");
        noTelpCell.textContent = dat.no_telp;
        row.appendChild(noTelpCell);

        // PTK
        const ptkCell = document.createElement("td");
        ptkCell.textContent = dat.ptk;
        row.appendChild(ptkCell);

        // NIP
        const nipCell = document.createElement("td");
        nipCell.textContent = dat.NIP;
        row.appendChild(nipCell);

        // Email
        const emailCell = document.createElement("td");
        emailCell.textContent = dat.email;
        row.appendChild(emailCell);

        // Action
        const actionCell = document.createElement("td");
        actionCell.classList.add("d-flex", "gap-5");

        // Edit Button
        const editButton = document.createElement("button");
        editButton.setAttribute("type", "button");
        editButton.classList.add("btn");
        editButton.setAttribute("data-bs-toggle", "modal");
        editButton.setAttribute("data-bs-target", `#editModal${dat.id}`);

        const editImg = document.createElement("img");
        editImg.setAttribute("src", "/img/edit.png");
        editImg.setAttribute("alt", "edit");

        editButton.appendChild(editImg);

        // Edit Modal
        const editModal = document.createElement("div");
        editModal.classList.add("modal", "fade");
        editModal.id = `editModal${dat.id}`;
        editModal.setAttribute("tabindex", "-1");
        editModal.setAttribute("aria-labelledby", `editModalLabel${dat.id}`);
        editModal.setAttribute("aria-hidden", "true");

        const modalDialog = document.createElement("div");
        modalDialog.classList.add("modal-dialog");

        const modalContent = document.createElement("div");
        modalContent.classList.add("modal-content");

        const modalHeader = document.createElement("div");
        modalHeader.classList.add("modal-header");

        const modalTitle = document.createElement("h1");
        modalTitle.classList.add("modal-title", "fs-5");
        modalTitle.id = `editModalLabel${dat.id}`;
        modalTitle.textContent = "Edit Pegawai";

        const closeButton = document.createElement("button");
        closeButton.setAttribute("type", "button");
        closeButton.classList.add("btn-close");
        closeButton.setAttribute("data-bs-dismiss", "modal");
        closeButton.setAttribute("aria-label", "Close");

        modalHeader.appendChild(modalTitle);
        modalHeader.appendChild(closeButton);

        const modalBody = document.createElement("div");
        modalBody.classList.add("modal-body", "d-flex", "gap-2");

        // Modal Form
        const form = document.createElement("form");
        form.setAttribute("action", "/pegawai"); // Change route as needed
        form.setAttribute("method", "post");

        const csrfToken = document.createElement("input");
        csrfToken.setAttribute("type", "hidden");
        csrfToken.setAttribute("name", "_token");
        csrfToken.setAttribute(
            "value",
            document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content")
        ); // Replace with dynamic token if necessary
        form.appendChild(csrfToken);

        const methodInput = document.createElement("input");
        methodInput.setAttribute("type", "hidden");
        methodInput.setAttribute("name", "_method");
        methodInput.setAttribute("value", "PUT");
        form.appendChild(methodInput);

        const idInput = document.createElement("input");
        idInput.setAttribute("type", "hidden");
        idInput.setAttribute("name", "id");
        idInput.setAttribute("id", dat.id + "id");
        idInput.setAttribute("value", dat.id);
        form.appendChild(idInput);

        const leftColumn = document.createElement("div");
        leftColumn.classList.add("w-50", "d-flex", "flex-column", "gap-4");

        const namaGroup = document.createElement("div");
        namaGroup.classList.add("form-group");

        const namaLabel = document.createElement("label");
        namaLabel.setAttribute("for", "nama");
        namaLabel.textContent = "Nama";
        namaGroup.appendChild(namaLabel);

        const namaInput = document.createElement("input");
        namaInput.setAttribute("required", "");
        namaInput.setAttribute("value", dat.nama);
        namaInput.setAttribute("type", "text");
        namaInput.classList.add("form-control");
        namaInput.setAttribute("id", dat.id + "nama");
        namaInput.setAttribute("name", "nama");
        namaInput.setAttribute("placeholder", "Masukkan Nama");
        namaGroup.appendChild(namaInput);

        leftColumn.appendChild(namaGroup);

        const emailGroup = document.createElement("div");
        emailGroup.classList.add("form-group");

        const emailLabel = document.createElement("label");
        emailLabel.setAttribute("for", "email");
        emailLabel.textContent = "Email";
        emailGroup.appendChild(emailLabel);

        const emailInput = document.createElement("input");
        emailInput.setAttribute("required", "");
        emailInput.setAttribute("value", dat.email);
        emailInput.setAttribute("type", "email");
        emailInput.classList.add("form-control");
        emailInput.setAttribute("id", dat.id + "email");
        emailInput.setAttribute("name", "email");
        emailInput.setAttribute("placeholder", "Masukkan Email");
        emailGroup.appendChild(emailInput);

        leftColumn.appendChild(emailGroup);

        const ptkGroup = document.createElement("div");

        const ptkLabel = document.createElement("label");
        ptkLabel.setAttribute("for", "ptk");
        ptkLabel.textContent = "PTK";
        ptkGroup.appendChild(ptkLabel);

        const ptkSelect = document.createElement("select");
        ptkSelect.classList.add("form-select");
        ptkSelect.setAttribute("name", "ptk");
        ptkSelect.setAttribute("aria-label", "PTK");

        const guruOption = document.createElement("option");
        guruOption.setAttribute("value", "guru");
        guruOption.textContent = "Guru";
        if (dat.ptk === "guru") {
            guruOption.setAttribute("selected", "");
        }
        ptkSelect.appendChild(guruOption);

        const tendikOption = document.createElement("option");
        tendikOption.setAttribute("value", "tendik");
        tendikOption.textContent = "Tendik";
        if (dat.ptk === "tendik") {
            tendikOption.setAttribute("selected", "");
        }
        ptkSelect.appendChild(tendikOption);

        ptkGroup.appendChild(ptkSelect);
        leftColumn.appendChild(ptkGroup);

        const rightColumn = document.createElement("div");
        rightColumn.classList.add("w-50", "d-flex", "flex-column", "gap-4");

        const noTelpGroup = document.createElement("div");
        noTelpGroup.classList.add("form-group");

        const noTelpLabel = document.createElement("label");
        noTelpLabel.setAttribute("for", "no_telp");
        noTelpLabel.textContent = "No Telp";
        noTelpGroup.appendChild(noTelpLabel);

        const noTelpInput = document.createElement("input");
        noTelpInput.setAttribute("required", "");
        noTelpInput.setAttribute("value", dat.no_telp);
        noTelpInput.setAttribute("type", "text");
        noTelpInput.setAttribute("inputmode", "numeric");
        noTelpInput.classList.add("form-control");
        noTelpInput.setAttribute("id", dat.id + "no_telp");
        noTelpInput.setAttribute("name", "no_telp");
        noTelpInput.setAttribute("placeholder", "Masukkan No HP");
        noTelpGroup.appendChild(noTelpInput);

        rightColumn.appendChild(noTelpGroup);

        const nipGroup = document.createElement("div");
        nipGroup.classList.add("form-group");

        const nipLabel = document.createElement("label");
        nipLabel.setAttribute("for", "NIP");
        nipLabel.textContent = "NIP";
        nipGroup.appendChild(nipLabel);

        const nipInput = document.createElement("input");
        nipInput.setAttribute("required", "");
        nipInput.setAttribute("value", dat.NIP);
        nipInput.setAttribute("type", "number");
        nipInput.setAttribute("inputmode", "numeric");
        nipInput.classList.add("form-control");
        nipInput.setAttribute("id", dat.id + "NIP");
        nipInput.setAttribute("name", "NIP");
        nipInput.setAttribute("placeholder", "Masukkan NIP");
        nipGroup.appendChild(nipInput);

        rightColumn.appendChild(nipGroup);

        form.appendChild(leftColumn);
        form.appendChild(rightColumn);
        modalBody.appendChild(form);

        const modalFooter = document.createElement("div");
        modalFooter.classList.add("modal-footer");

        const closeModalButton = document.createElement("button");
        closeModalButton.setAttribute("type", "button");
        closeModalButton.classList.add("btn", "btn-secondary");
        closeModalButton.setAttribute("data-bs-dismiss", "modal");
        closeModalButton.textContent = "Close";

        const saveChangesButton = document.createElement("button");
        saveChangesButton.addEventListener("click", () => {
            form.submit();
        });
        saveChangesButton.setAttribute("type", "submit");
        saveChangesButton.classList.add("btn", "btn-primary");
        saveChangesButton.textContent = "Save changes";

        modalFooter.appendChild(closeModalButton);
        modalFooter.appendChild(saveChangesButton);

        modalContent.appendChild(modalHeader);
        modalContent.appendChild(modalBody);
        modalContent.appendChild(modalFooter);

        modalDialog.appendChild(modalContent);
        editModal.appendChild(modalDialog);

        // Append edit button and modal to action cell
        actionCell.appendChild(editButton);
        actionCell.appendChild(editModal);

        // Delete Button
        const deleteLink = document.createElement("a");
        deleteLink.setAttribute("href", `/pegawai/hapus/${dat.id}`); // Change route as needed
        deleteLink.setAttribute(
            "onclick",
            'return confirm("Yakin ingin hapus?")'
        );

        const deleteButton = document.createElement("button");
        deleteButton.classList.add("btn");

        const deleteImg = document.createElement("img");
        deleteImg.setAttribute("src", "/img/hapus.png");
        deleteImg.setAttribute("alt", "hapus");

        deleteButton.appendChild(deleteImg);
        deleteLink.appendChild(deleteButton);

        actionCell.appendChild(deleteLink);

        row.appendChild(actionCell);
        tbody.appendChild(row);
    });

    table.appendChild(tbody);

    // Append the table to the desired container
    const container = document.getElementById("myTable");
    container.innerHTML = "";
    const topPagination = createPagination(dataAll);
    const pagination = createPagination(dataAll);
    container.appendChild(topPagination);
    container.appendChild(table);
    container.appendChild(pagination);
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
        ptk: document.getElementById("body_ptk").value,
    };
    const apiUrl = `/pegawai/search`;
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
            throw new Error("Network response was not ok " + response);
        }
        const responseText = await response.text();
        // console.log("Raw response text:", responseText);

        // Try parsing the response as JSON
        const data = JSON.parse(responseText);

        // Set the data to a variable
        const myDataVariable = data.datas.data;

        // Here you can manipulate the data or use it to update the UI
        createTable(myDataVariable, data.datas);
    } catch (error) {
        // Handle any errors that occurred during the fetch
        console.error("Error sending data:", error);
    }
}

async function searchPag(apiUrl) {
    const dataToSend = {
        search: document.getElementById("search_2").value,
        ptk: document.getElementById("body_ptk").value,
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
        createTable(myDataVariable, data.datas);
    } catch (error) {
        // Handle any errors that occurred during the fetch
        console.error("Error sending data:", error);
    }
}

// Example data to send

// Call search function to send data
