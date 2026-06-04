// =========================================
// LOGIKA HALAMAN MANAJEMEN USER
// Fitur: Filter Data Tabel Pengguna
// =========================================

document.addEventListener('DOMContentLoaded', () => {
    const searchUser = document.getElementById('searchUser');
    const roleUserFilter = document.getElementById('roleUserFilter');
    const statusUserFilter = document.getElementById('statusUserFilter');

    function applyUserFilters() {
        const searchVal = searchUser ? searchUser.value.toLowerCase() : '';
        const roleVal = roleUserFilter ? roleUserFilter.value.toLowerCase() : '';
        const statusVal = statusUserFilter ? statusUserFilter.value.toLowerCase() : '';

        // Hanya ambil baris yang memiliki class .user-row
        const userRows = document.querySelectorAll('.user-row');

        userRows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            const rowRole = row.getAttribute('data-role') ? row.getAttribute('data-role').toLowerCase() : '';
            const rowStatus = row.getAttribute('data-status') ? row.getAttribute('data-status').toLowerCase() : '';

            const matchSearch = rowText.includes(searchVal);
            const matchRole = roleVal === '' || rowRole === roleVal;
            const matchStatus = statusVal === '' || rowStatus === statusVal;

            if (matchSearch && matchRole && matchStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (searchUser) searchUser.addEventListener('keyup', applyUserFilters);
    if (roleUserFilter) roleUserFilter.addEventListener('change', applyUserFilters);
    if (statusUserFilter) statusUserFilter.addEventListener('change', applyUserFilters);
});