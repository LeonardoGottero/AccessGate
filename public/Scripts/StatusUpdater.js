document.addEventListener('DOMContentLoaded', function() {
    const statusElements = document.querySelectorAll('.device-status');
    if (statusElements.length === 0) {
        return;
    }
    function updateAllStatuses() {
        statusElements.forEach(span => {
            const DeviceId = span.dataset.uid;
            if (!DeviceId) {
                return;
            }
            fetch(`${baseUrl}Api/GetStatus?device=${DeviceId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status && span.textContent.trim() !== data.status) {
                         span.textContent = data.status;
                    }
                })
                .catch(error => {
                    console.error('Error fetching status for ' + DeviceId + ':', error);
                    span.textContent = 'Desconocido';
                });
        });
    }
    setInterval(updateAllStatuses, 2000);
});