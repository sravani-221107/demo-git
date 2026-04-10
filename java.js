const RecordManager = {
    records: [
        { id: 1, name: "Ravi Kumar", caseNo: "101", crime: "Murder", status: "Arrested" },
        { id: 2, name: "Suresh Babu", caseNo: "103", crime: "Robbery", status: "Investigating" },
        { id: 3, name: "Kapil varma", caseNo: "101", crime: "Murder", status: "Arrested" },
        { id: 4, name: "Ravi Kumar", caseNo: "106", crime: "Rape attempt", status: "Searching" }
    ],
    nextId: 5,

    addRecord: function(name, caseNo, crime, status) {
        let newRecord = {
            id: this.nextId++,
            name: name,
            caseNo: caseNo,
            crime: crime,
            status: status
        };
        this.records.push(newRecord);
        alert("Record added successfully!");
        this.renderUI();
    },

    updateRecord: function(id) {
        let record = this.records.find(r => r.id === id);
        if (record) {
            let newStatus = prompt("Enter new status for " + record.name + ":", record.status);
            if (newStatus !== null && newStatus.trim() !== "") {
                record.status = newStatus;
                alert("Record updated successfully!");
                this.renderUI();
            }
        }
    },

    deleteRecord: function(id) {
        let confirmDelete = confirm("Are you sure you want to delete this record?");
        if (confirmDelete) {
            this.records = this.records.filter(r => r.id !== id);
            alert("Record deleted!");
            this.renderUI();
        }
    },

    renderCards: function() {
        const container = document.getElementById("cards-container");
        if (!container) return;
        container.innerHTML = "";
        this.records.forEach(record => {
            let card = document.createElement("div");
            card.className = "record-card";
            card.innerHTML = `
                <h3>Name: ${record.name}</h3>
                <p>Crime: ${record.crime}</p>
                <p>Case No: ${record.caseNo}</p>
                <p>Status: ${record.status}</p>
                <div style="margin-top: 15px; display: flex; justify-content: center; gap: 10px;">
                    <button onclick="RecordManager.updateRecord(${record.id})" style="background-color: #ffc107; border: none; padding: 8px 12px; cursor: pointer; border-radius: 5px; color: black; font-weight: bold;">Edit Status</button>
                    <button onclick="RecordManager.deleteRecord(${record.id})" style="background-color: #dc3545; border: none; padding: 8px 12px; cursor: pointer; border-radius: 5px; color: white; font-weight: bold;">Delete</button>
                </div>
            `;
            container.appendChild(card);
        });
    },

    renderTable: function() {
        const tbody = document.getElementById("table-body");
        if (!tbody) return;
        tbody.innerHTML = "";
        this.records.forEach(record => {
            let tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${record.name}</td>
                <td>${record.caseNo}</td>
                <td>${record.crime}</td>
                <td>${record.status}</td>
                <td>
                    <button onclick="RecordManager.updateRecord(${record.id})" style="background-color: #ffc107; border: none; padding: 5px 10px; cursor: pointer; border-radius: 4px; color: black; font-weight: bold;">Edit</button>
                    <button onclick="RecordManager.deleteRecord(${record.id})" style="background-color: #dc3545; border: none; padding: 5px 10px; cursor: pointer; border-radius: 4px; color: white; font-weight: bold;">Delete</button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    },

    renderUI: function() {
        this.renderCards();
        this.renderTable();
    }
};

document.addEventListener("DOMContentLoaded", function() {
    RecordManager.renderUI();

    const form = document.getElementById("add-record-form");
    if (form) {
        form.addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent page reload
            const name = document.getElementById("r-name").value;
            const caseNo = document.getElementById("r-case").value;
            const crime = document.getElementById("r-crime").value;
            const status = document.getElementById("r-status").value;
            
            RecordManager.addRecord(name, caseNo, crime, status);
            form.reset();
        });
    }

    // Example of input event listener on form inputs
    const inputs = document.querySelectorAll("#add-record-form input");
    inputs.forEach(input => {
        input.addEventListener("input", function() {
            // Can be used to validate fields in real time
            if (this.value.trim() !== "") {
                this.style.borderColor = "green";
            } else {
                this.style.borderColor = "#ccc";
            }
        });
    });
});