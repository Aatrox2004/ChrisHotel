document.addEventListener("DOMContentLoaded", () => {
    const calendarBody = document.getElementById('calendar-body');
    const dateInput = document.getElementById('date-range');
    const roomsPopup = document.getElementById('roomsPopup');
    const roomsLabel = document.getElementById('rooms-label');
    const roomsDetails = document.getElementById('rooms-details');
    const hiddenCheckin = document.getElementById('reservation-checkin');
    const hiddenCheckout = document.getElementById('reservation-checkout');

    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();
    let checkInDate = null;
    let checkOutDate = null;
    let tempCheckIn = null;
    let tempCheckOut = null;
    let tempAdults = null;
    let tempChildren = null;

    let guestData = { adults: 2, children: 0 };
    window.guestData = guestData;

    // Calendar functions
    function resetCalendar() {
        currentMonth = new Date().getMonth();
        currentYear = new Date().getFullYear();
        generateCalendar();
    }

    function generateCalendar() {
        calendarBody.innerHTML = '';
        for (let i = 0; i < 2; i++) {
            const month = (currentMonth + i) % 12;
            const year = currentYear + Math.floor((currentMonth + i) / 12);
            const monthContainer = document.createElement('div');
            monthContainer.classList.add('month-container');

            const monthTitle = document.createElement('div');
            monthTitle.classList.add('month-title');
            monthTitle.textContent = `${new Date(year, month).toLocaleString('default', { month: 'long' })} ${year}`;
            monthContainer.appendChild(monthTitle);

            const weekdays = document.createElement('div');
            weekdays.classList.add('weekdays');
            weekdays.innerHTML = "<div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>";
            monthContainer.appendChild(weekdays);

            const daysDiv = document.createElement('div');
            daysDiv.classList.add('days');

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            for (let j = 0; j < firstDay; j++) {
                const emptyCell = document.createElement('div');
                emptyCell.classList.add('day');
                emptyCell.style.visibility = 'hidden';
                daysDiv.appendChild(emptyCell);
            }
            for (let day = 1; day <= daysInMonth; day++) {
                const currentDate = new Date(year, month, day);
                const dayDiv = document.createElement('div');
                dayDiv.classList.add('day');
                dayDiv.textContent = day;
                if (currentDate < today) dayDiv.classList.add('disabled');
                if (tempCheckIn && currentDate.getTime() === tempCheckIn.getTime()) dayDiv.classList.add('check-in');
                if (tempCheckOut && currentDate.getTime() === tempCheckOut.getTime()) dayDiv.classList.add('check-out');
                if (tempCheckIn && tempCheckOut && currentDate > tempCheckIn && currentDate < tempCheckOut) dayDiv.classList.add('range');
                dayDiv.addEventListener('click', () => selectDate(currentDate));
                daysDiv.appendChild(dayDiv);
            }
            monthContainer.appendChild(daysDiv);
            calendarBody.appendChild(monthContainer);
        }
    }

    function selectDate(date) {
        if (!tempCheckIn || (tempCheckIn && tempCheckOut)) {
            tempCheckIn = date;
            tempCheckOut = null;
        } else if (date > tempCheckIn) {
            tempCheckOut = date;
            checkInDate = tempCheckIn;
            checkOutDate = tempCheckOut;
            updateInput();
        }
        window.checkInDate = checkInDate;
        window.checkOutDate = checkOutDate;
        generateCalendar();
    }

    function updateInput() {
        if (checkInDate && checkOutDate) {
            dateInput.value = `${checkInDate.toLocaleDateString('en-CA')} → ${checkOutDate.toLocaleDateString('en-CA')}`;
            hiddenCheckin.value = checkInDate.toLocaleDateString('en-CA');
            hiddenCheckout.value = checkOutDate.toLocaleDateString('en-CA');
        }
    }

    window.prevMonth = function () {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        generateCalendar();
    };

    window.nextMonth = function () {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        generateCalendar();
    };

    // Guest selection
    function toggleRoomsPopup() {
        roomsPopup.style.display = roomsPopup.style.display === 'block' ? 'none' : 'block';
        if (roomsPopup.style.display === 'block') {
            const adultsValue = tempAdults !== null ? tempAdults : guestData.adults;
            const childrenValue = tempChildren !== null ? tempChildren : guestData.children;
            roomsDetails.innerHTML = `
                <div class="room-select-adults">
                    <label>Adults:</label>
                    <select id="adults-input">
                        ${[1, 2, 3].map(num => `<option value="${num}" ${adultsValue === num ? 'selected' : ''}>${num}</option>`).join('')}
                    </select>
                </div>
                <div class="room-select-children">
                    <label>Children:</label>
                    <select id="children-input">
                        ${[0, 1, 2, 3].map(num => `<option value="${num}" ${childrenValue === num ? 'selected' : ''}>${num}</option>`).join('')}
                    </select>
                </div>
                <div class="accommodate-error" style="display: none; color: red;">Total guests cannot exceed 5</div>
            `;
        }
    }
    window.toggleRoomsPopup = toggleRoomsPopup;

    function saveGuests() {
        tempAdults = parseInt(document.getElementById('adults-input').value);
        tempChildren = parseInt(document.getElementById('children-input').value);

        if (tempAdults + tempChildren > 5) {
            document.querySelector('.accommodate-error').style.display = 'block';
            return;
        }

        document.querySelector('.accommodate-error').style.display = 'none';
        guestData.adults = tempAdults;
        guestData.children = tempChildren;
        roomsLabel.textContent = `${guestData.adults} Adult${guestData.adults > 1 ? 's' : ''}, ${guestData.children} Child${guestData.children !== 1 ? 'ren' : ''}`;
        roomsPopup.style.display = 'none';
    }
    window.saveGuests = saveGuests;

    window.validateAndProceed = async function () {
        if (!checkInDate || !checkOutDate) {
            alert('Please select check-in and check-out dates');
            return;
        }
        if (guestData.adults < 1) {
            alert('At least one adult is required');
            return;
        }

        // Save to session via API call
        try {
            const response = await fetch(`${BASE_URL}index.php?url=Reservation/SavePreSelection`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    checkin: checkInDate.toLocaleDateString('en-CA'),
                    checkout: checkOutDate.toLocaleDateString('en-CA'),
                    adults: guestData.adults,
                    children: guestData.children
                })
            });

            // Read the response body once
            const responseText = await response.text();
            let result;
            try {
                result = JSON.parse(responseText);
            } catch (e) {
                console.error('Non-JSON response received:', responseText);
                alert('Server error: Invalid response format');
                return;
            }

            if (result.success) {
                window.location.href = `${BASE_URL}index.php?url=Reservation`;
            } else {
                alert(result.message || 'Error saving selections');
            }
        } catch (e) {
            console.error('Fetch error:', e);
            alert('Error saving selections: ' + e.message);
        }
    };

    // Initialize
    generateCalendar();
});