const calendarPopup = document.getElementById('calendarPopup');
const calendarBody = document.getElementById('calendar-body');
const dateInput = document.getElementById('date-range');
const roomsPopup = document.getElementById('roomsPopup');
const roomsLabel = document.getElementById('rooms-label');
const roomCountSpan = document.getElementById('room-count');
const roomsDetails = document.getElementById('rooms-details');

let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();
let checkInDate = null;
let checkOutDate = null;
let roomCount = 1;
let roomsData = [{ adults: 2, children: 0 }];

function toggleCalendar() {
  if (calendarPopup.style.display === 'block') {
    calendarPopup.style.display = 'none';
  } else {
    calendarPopup.style.display = 'block';
    resetCalendar();
  }
}

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

      if (currentDate < today) {
        dayDiv.classList.add('disabled');
      }

      if (checkInDate && currentDate.getTime() === checkInDate.getTime()) {
        dayDiv.classList.add('check-in');
      }

      if (checkOutDate && currentDate.getTime() === checkOutDate.getTime()) {
        dayDiv.classList.add('check-out');
      }

      if (checkInDate && checkOutDate && currentDate > checkInDate && currentDate < checkOutDate) {
        dayDiv.classList.add('range');
      }

      dayDiv.addEventListener('click', () => selectDate(currentDate));
      daysDiv.appendChild(dayDiv);
    }

    monthContainer.appendChild(daysDiv);
    calendarBody.appendChild(monthContainer);
  }

  document.getElementById('calendarTitle').textContent =
    `${new Date(currentYear, currentMonth).toLocaleString('default', { month: 'long' })} ${currentYear} - ${new Date(currentYear, currentMonth + 1).toLocaleString('default', { month: 'long' })} ${currentYear}`;
}

function selectDate(date) {
  if (!checkInDate || (checkInDate && checkOutDate)) {
    checkInDate = date;
    checkOutDate = null;
  } else if (date > checkInDate) {
    checkOutDate = date;
  } else {
    checkInDate = date;
    checkOutDate = null;
  }

  updateInput();
  generateCalendar();

  // Hide popup only when both dates are selected
  if (checkInDate && checkOutDate) {
    calendarPopup.style.display = 'none';
  }
}

function updateInput() {
  if (checkInDate && checkOutDate) {
    dateInput.value = `${formatDate(checkInDate)} → ${formatDate(checkOutDate)}`;
    document.getElementById('reservation-checkin').value = formatDateISO(checkInDate);
    document.getElementById('reservation-checkout').value = formatDateISO(checkOutDate);
  } else if (checkInDate) {
    dateInput.value = `${formatDate(checkInDate)} -`;
  } else {
    dateInput.value = '';
  }
}

function formatDate(date) {
  return `${date.getDate()} ${date.toLocaleString('default', { month: 'short' })} ${date.getFullYear()}`;
}

function formatDateISO(date) {
  return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
}

function nextMonth() {
  currentMonth += 1;
  generateCalendar();
}

function prevMonth() {
  currentMonth -= 1;
  generateCalendar();
}

function closeCalendar() {
  calendarPopup.style.display = 'none';
}

// Modified click-outside listener with slight delay
document.addEventListener('click', (e) => {
  // Delay to allow selectDate to process first
  setTimeout(() => {
    if (!calendarPopup.contains(e.target) && e.target !== dateInput && checkInDate && checkOutDate) {
      calendarPopup.style.display = 'none';
    }
  }, 0);
});

generateCalendar();

function toggleRoomsPopup() {
  roomsPopup.style.display = roomsPopup.style.display === 'block' ? 'none' : 'block';
  if (roomsPopup.style.display === 'block') {
    renderRooms();
  }
}

function changeRooms(change) {
  roomCount += change;
  if (roomCount < 1) roomCount = 1;
  if (roomCount > 5) roomCount = 5;

  while (roomsData.length < roomCount) {
    roomsData.push({ adults: 2, children: 0 });
  }
  roomsData = roomsData.slice(0, roomCount);

  roomCountSpan.textContent = roomCount;
  renderRooms();
}

function renderRooms() {
  roomsDetails.innerHTML = '';
  roomsData.forEach((room, index) => {
    const roomDiv = document.createElement('div');
    roomDiv.classList.add('room-detail');
    roomDiv.innerHTML = `
      <h4>Room ${index + 1}</h4>
      <label>Adults</label>
      <select onchange="updateRoom(${index}, 'adults', this.value)">
        ${[1,2,3,4].map(num => `<option value="${num}" ${room.adults == num ? 'selected' : ''}>${num}</option>`).join('')}
      </select>
      <label>Children</label>
      <select onchange="updateRoom(${index}, 'children', this.value)">
        ${[0,1,2,3].map(num => `<option value="${num}" ${room.children == num ? 'selected' : ''}>${num}</option>`).join('')}
      </select>
    `;
    roomsDetails.appendChild(roomDiv);
  });
}

function updateRoom(index, field, value) {
  roomsData[index][field] = parseInt(value);
}

function saveRooms() {
  let totalAdults = roomsData.reduce((sum, r) => sum + r.adults, 0);
  let totalChildren = roomsData.reduce((sum, r) => sum + r.children, 0);
  roomsLabel.textContent = `${roomCount} room${roomCount > 1 ? 's' : ''}, ${totalAdults} adult${totalAdults > 1 ? 's' : ''}, ${totalChildren} child${totalChildren !== 1 ? 'ren' : ''}`;
  document.getElementById('reservation-guests').value = totalAdults + totalChildren;
  document.getElementById('reservation-rooms').value = JSON.stringify(roomsData);
  roomsPopup.style.display = 'none';
}

document.addEventListener('click', (event) => {
  if (!roomsPopup.contains(event.target) && !event.target.closest('.rooms-selector')) {
    roomsPopup.style.display = 'none';
  }
});

function validateForm() {
  if (!checkInDate || !checkOutDate) {
    alert('Please select both check-in and check-out dates.');
    return false;
  }

  if (roomsData.length === 0 || roomsData.every(room => room.adults === 0 && room.children === 0)) {
    alert('Please select at least one room with guests.');
    return false;
  }

  if (checkOutDate <= checkInDate) {
    alert('Check-out date must be after check-in date.');
    return false;
  }

  return true;
}

document.addEventListener('keydown', (event) => {
  if (event.key === 'Enter' && !event.target.closest('.submit-btn')) {
    event.preventDefault();
  }
});