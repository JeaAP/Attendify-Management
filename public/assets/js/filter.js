const kelasOptions = {
    "RPL": ["X PPL 1", "X PPL 2", "XI PPL 1", "XI PPL 2", "XII PPL 1", "XII PPL 2"],
    "TBS": ["X TBS 1", "X TBS 2", "X TBS 3", "XI TBS 1", "XI TBS 2", "XI TBS 3", "XII TBS 1", "XII TBS 2", "XII TBS 3"],
    "KUL": ["X KUL 1", "X KUL 2", "X KUL 3", "XI KUL 1", "XI KUL 2", "XI KUL 3", "XII KUL 1", "XII KUL 2", "XII KUL 3"],
    "PH": ["X PH 1", "X PH 2", "X PH 3", "XI PH 1", "XI PH 2", "XI PH 3", "XII PH 1", "XII PH 2", "XII PH 3"],
    "ULW": ["X ULW 1", "XI ULW 1", "XII ULW 1"]
};

function updateKelasFilter() {
    let selectedJurusan = document.getElementById("jurusanFilter").value;
    let kelasSelect = document.getElementById("kelasFilter");
    
    // Reset kelas filter
    kelasSelect.innerHTML = "<option value=''>Kelas</option>";
    
    if (selectedJurusan && kelasOptions[selectedJurusan]) {
        kelasOptions[selectedJurusan].forEach(kelas => {
            let option = document.createElement("option");
            option.value = kelas;
            option.textContent = kelas;
            kelasSelect.appendChild(option);
        });
    }
}

function filterByDate() {
    let selectedDate = document.getElementById("filterDate").value;
    let rows = document.querySelectorAll("#dataTable tr");
    let hasData = false;
    
    // Hapus pesan tidak ada data sebelum melakukan filtering ulang
    let noDataMessage = document.getElementById("noDataMessage");
    if (noDataMessage) {
        noDataMessage.remove();
    }
    
    rows.forEach(row => {
        let rowDateCell = row.cells[3];
        if (!rowDateCell) return;
        
        let rowDate = rowDateCell.textContent.trim();
        
        // Konversi format tanggal dari d-m-Y ke YYYY-MM-DD jika format sesuai
        let parts = rowDate.split("-");
        if (parts.length === 3) {
            let formattedRowDate = `${parts[2]}-${parts[1]}-${parts[0]}`;

            if (selectedDate === "" || formattedRowDate === selectedDate) {
                row.style.display = "";
                hasData = true;
            } else {
                row.style.display = "none";
            }
        }
    });
    
    // Jika tidak ada data yang cocok, tambahkan pesan tidak ada data
    if (!hasData) {
        noDataMessage = document.createElement("tr");
        noDataMessage.id = "noDataMessage";
        noDataMessage.innerHTML = "<td colspan='8' class='text-center text-muted'>Tidak ada data untuk tanggal " + selectedDate + "</td>";
        document.getElementById("dataTable").appendChild(noDataMessage);
    }
}

function filterByJurusan() {
    updateKelasFilter();
    
    let selectedJurusan = document.getElementById("jurusanFilter").value;
    
    // Mapping nama jurusan dari HTML ke singkatan yang digunakan di tabel
    const jurusanMap = {
        "RPL": "PPL",
        "TBS": "TBS",
        "KUL": "KUL",
        "PH": "PH",
        "ULW": "ULW"
    };
    
    let jurusanSingkatan = jurusanMap[selectedJurusan] || selectedJurusan;

    let rows = document.querySelectorAll("#dataTable tr");
    let hasData = false;
    
    rows.forEach(row => {
        let rowKelasCell = row.cells[1];
        if (!rowKelasCell) return;
        
        let rowKelas = rowKelasCell.textContent.trim();
        
        if (selectedJurusan === "" || rowKelas.includes(jurusanSingkatan)) {
            row.style.display = "";
            hasData = true;
        } else {
            row.style.display = "none";
        }
    });

    toggleNoDataMessage(hasData);
}


function filterByKelas() {
    let selectedKelas = document.getElementById("kelasFilter").value;
    let rows = document.querySelectorAll("#dataTable tr");
    let hasData = false;
    
    rows.forEach(row => {
        let rowKelasCell = row.cells[1];
        if (!rowKelasCell) return;
        
        let rowKelas = rowKelasCell.textContent.trim();
        if (selectedKelas === "" || rowKelas === selectedKelas) {
            row.style.display = "";
            hasData = true;
        } else {
            row.style.display = "none";
        }
    });

    toggleNoDataMessage(hasData);
}

function filterByStatus() {
    let selectedStatus = document.getElementById("statusFilter").value;
    let rows = document.querySelectorAll("#dataTable tr");
    let hasData = false;
    
    rows.forEach(row => {
        let rowStatusCell = row.cells[5];
        if (!rowStatusCell) return;
        
        let rowStatus = rowStatusCell.textContent.trim();
        if (selectedStatus === "" || rowStatus === selectedStatus) {
            row.style.display = "";
            hasData = true;
        } else {
            row.style.display = "none";
        }
    });
    
    toggleNoDataMessage(hasData);
}

function filterByMood() {
    let selectedMood = document.getElementById("moodFilter").value;
    let rows = document.querySelectorAll("#dataTable tr");
    let hasData = false;
    
    rows.forEach(row => {
        let rowMoodCell = row.cells[6];
        if (!rowMoodCell) return;
        
        let rowMood = rowMoodCell.textContent.trim();
        if (selectedMood === "" || rowMood === selectedMood) {
            row.style.display = "";
            hasData = true;
        } else {
            row.style.display = "none";
        }
    });
    
    toggleNoDataMessage(hasData);
}

function filterBySearch() {
    let searchText = document.getElementById("searchInput").value.toLowerCase();
    let rows = document.querySelectorAll("#dataTable tr");
    let hasData = false;
    
    rows.forEach(row => {
        let rowNameCell = row.cells[0]; // Kolom Nama Siswa
        let rowClassCell = row.cells[1]; // Kolom Kelas
        let rowMajorCell = row.cells[2]; // Kolom Jurusan
        let rowDateCell = row.cells[3]; // Kolom Tanggal
        let rowTimeCell = row.cells[4]; // Kolom Waktu
        let rowStatusCell = row.cells[5]; // Kolom Status
        let rowMoodCell = row.cells[6]; // Kolom Mood
        if (!rowNameCell) return;
        
        let rowText = [
            rowNameCell.textContent.toLowerCase(),
            rowClassCell ? rowClassCell.textContent.toLowerCase() : "",
            rowMajorCell ? rowMajorCell.textContent.toLowerCase() : "",
            rowDateCell ? rowDateCell.textContent.toLowerCase() : "",
            rowTimeCell ? rowTimeCell.textContent.toLowerCase() : "",
            rowStatusCell ? rowStatusCell.textContent.toLowerCase() : "",
            rowMoodCell ? rowMoodCell.textContent.toLowerCase() : ""
        ].join(" ");
        
        if (searchText === "" || rowText.includes(searchText)) {
            row.style.display = "";
            hasData = true;
        } else {
            row.style.display = "none";
        }
    });

    toggleNoDataMessage(hasData);
}

function resetFilter() {
    document.getElementById('jurusanFilter').selectedIndex = 0;
    document.getElementById('kelasFilter').selectedIndex = 0;
    document.getElementById('statusFilter').selectedIndex = 0;
    document.getElementById('moodFilter').selectedIndex = 0;
    document.getElementById('searchInput').value = "";
}

function toggleNoDataMessage(hasData) {
    let noDataMessage = document.getElementById("noDataMessage");
    if (!hasData) {
        if (!noDataMessage) {
            noDataMessage = document.createElement("tr");
            noDataMessage.id = "noDataMessage";
            noDataMessage.innerHTML = "<td colspan='8' class='text-center text-muted'>Tidak ada data untuk filter yang dipilih</td>";
            document.getElementById("dataTable").appendChild(noDataMessage);
        }
    } else {
        if (noDataMessage) {
            noDataMessage.remove();
        }
    }
}

function refreshData() {
    location.reload();
}

function resetFilter() {
    const urlParams = new URLSearchParams(window.location.search);
            
    const action = urlParams.get('action');
    const page = urlParams.get('page');

    urlParams.forEach(function(value, key) {
        if (key !== 'action' && key !== 'page') {
            urlParams.delete(key);
        }
    });

    if (action) {
        urlParams.set('action', action);
    }
    if (page) {
        urlParams.set('page', page);
    }

    window.location.search = urlParams.toString();
}

function isFilterActive() {
    return (
        document.getElementById("jurusanFilter").value !== "" ||
        document.getElementById("kelasFilter").value !== "" ||
        document.getElementById("statusFilter").value !== "" ||
        document.getElementById("moodFilter").value !== "" ||
        document.getElementById("searchInput").value.trim() !== "" ||
        document.getElementById("filterDate").value !== ""
    );
}

let resetInterval;

function startResetInterval() {
    // Clear any existing interval first
    if (resetInterval) {
        clearInterval(resetInterval);
    }
    
    // Only start the interval if no filters are active
    if (!isFilterActive()) {
        resetInterval = setInterval(() => {
            resetFilter();
        }, 10000);
    }
}

function handleFilterChange() {
    if (isFilterActive()) {
        // Clear the interval if filters are active
        if (resetInterval) {
            clearInterval(resetInterval);
            resetInterval = null;
        }
    } else {
        // Start the interval if no filters are active
        startResetInterval();
    }
}

document.addEventListener("DOMContentLoaded", function () {
    // Add event listeners for all filter inputs
    document.getElementById("filterDate").addEventListener("input", () => {
        filterByDate();
        handleFilterChange();
    });
    document.getElementById("jurusanFilter").addEventListener("change", () => {
        filterByJurusan();
        handleFilterChange();
    });
    document.getElementById("kelasFilter").addEventListener("change", () => {
        filterByKelas();
        handleFilterChange();
    });
    document.getElementById("statusFilter").addEventListener("change", () => {
        filterByStatus();
        handleFilterChange();
    });
    document.getElementById("moodFilter").addEventListener("change", () => {
        filterByMood();
        handleFilterChange();
    });
    document.getElementById("searchInput").addEventListener("input", () => {
        filterBySearch();
        handleFilterChange();
    });
    document.getElementById("refreshButton").addEventListener("click", refreshData);
    document.getElementById("resetButton").addEventListener("click", () => {
        resetFilter();
        startResetInterval(); // Restart interval after reset
    });

    const urlParams = new URLSearchParams(window.location.search);
    if(urlParams.has('status')) {
        document.getElementById("statusFilter").value = urlParams.get('status');
        filterByStatus();
    }
    if(urlParams.has('mood')) {
        document.getElementById("moodFilter").value = urlParams.get('mood');
        filterByMood();
    }

    // Start the initial interval if no filters are active
    startResetInterval();
});
