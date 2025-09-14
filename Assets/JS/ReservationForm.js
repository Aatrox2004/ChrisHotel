document.addEventListener("DOMContentLoaded", () => {
  // ---------------- Element refs ----------------
  const calendarPopup = document.getElementById('calendarPopup');
  const calendarBody = document.getElementById('calendar-body');
  const dateInput = document.getElementById('date-range');
  const roomsPopup = document.getElementById('roomsPopup');
  const roomsLabel = document.getElementById('rooms-label');
  const roomsDetails = document.getElementById('rooms-details');
  const roomsContainer = document.getElementById('roomsContainer');
  const cartPopup = document.getElementById('cartPopup');
  const cartDetails = document.getElementById('cart-details');
  const totalAmountEl = document.getElementById('total-amount');

  // Hidden inputs used when submitting
  const hiddenCheckin = document.getElementById('reservation-checkin');
  const hiddenCheckout = document.getElementById('reservation-checkout');
  const hiddenAdults = document.getElementById('reservation-adults');
  const hiddenChildren = document.getElementById('reservation-children');
  const hiddenRooms = document.getElementById('reservation-room');
  const hiddenRoomPrice = document.getElementById('reservation-room-price');
  const formCheckout = document.querySelector('.form-checkout');
  const reservationIdInput = document.getElementById('reservation-id');
  const roomId = document.getElementById('room-id');

  reservationIdInput.value = generateReservationID();

  // Calendar state
  let currentMonth = new Date().getMonth();
  let currentYear = new Date().getFullYear();
  let checkInDate = null;
  let checkOutDate = null;

  let tempCheckIn = null;
  let tempCheckOut = null;
  let tempAdults = null;
  let tempChildren = null;

  // Room state (only 1 room now)
  let roomData = { adults: 2, children: 0, selectedRoom: null };
  window.roomData = roomData;

  // ---------------- Calendar functions ----------------
  function toggleCalendar() {
    if (calendarPopup.style.display === 'block') {
      closeCalendar();
      return;
    }
    tempCheckIn = checkInDate;
    tempCheckOut = checkOutDate;
    calendarPopup.style.display = 'block';
    resetCalendar();
  }
  dateInput.addEventListener("click", toggleCalendar);
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
      const today = new Date(); today.setHours(0,0,0,0);

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
      calendarPopup.style.display = 'none';
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
      loadRooms();
      renderCart();
    }
  }
  window.closeCalendar = function() {
    calendarPopup.style.display = 'none';
  };
  window.prevMonth = function() {
    currentMonth--;
    if (currentMonth < 0) {
      currentMonth = 11;
      currentYear--;
    }
    generateCalendar();
  };
  window.nextMonth = function() {
    currentMonth++;
    if (currentMonth > 11) {
      currentMonth = 0;
      currentYear++;
    }
    generateCalendar();
  };

  // ---------------- Rooms selection ----------------
  function toggleRoomsPopup() {
    roomsPopup.style.display = roomsPopup.style.display === 'block' ? 'none' : 'block';
    if (roomsPopup.style.display === 'block') {
      // Use temp values if set, otherwise fall back to roomData
      const adultsValue = tempAdults !== null ? tempAdults : roomData.adults;
      const childrenValue = tempChildren !== null ? tempChildren : roomData.children;
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

  function saveRooms() {
    // Update temp values from dropdowns
    tempAdults = parseInt(document.getElementById('adults-input').value);
    tempChildren = parseInt(document.getElementById('children-input').value);

    // Validate total guests
    if (tempAdults + tempChildren > 5) {
      document.querySelector('.accommodate-error').style.display = 'block';
      return;
    }

    // If validation passes, update roomData and hidden fields
    document.querySelector('.accommodate-error').style.display = 'none';
    roomData.adults = tempAdults;
    roomData.children = tempChildren;
    roomsLabel.textContent = `${roomData.adults} Adult${roomData.adults > 1 ? 's' : ''}, ${roomData.children} Child${roomData.children !== 1 ? 'ren' : ''}`;
    hiddenAdults.value = roomData.adults;
    hiddenChildren.value = roomData.children;
    hiddenRooms.value = roomData.selectedRoom.roomType;
    roomsPopup.style.display = 'none';
    loadRooms();
    renderCart();
  }
  window.saveRooms = saveRooms;

  function closeRoomsPopup() {
    roomsPopup.style.display = 'none';
    // Keep tempAdults and tempChildren unchanged to preserve selections
  }
  window.closeRoomsPopup = closeRoomsPopup;

  // ---------------- Filtering ----------------
  function filterRooms() {
    document.querySelectorAll(".room-card").forEach(card => {
      const requiredGuests = roomData.adults + roomData.children;
      const max = parseInt(card.dataset.max, 10) || 0;
      card.style.display = max >= requiredGuests ? "block" : "none";
    });
  }

  // ---------------- Load rooms via API ----------------
  async function loadRooms() {
    roomsContainer.innerHTML = '<p>Loading...</p>';
    try {
      const response = await fetch(`${BASE_URL}index.php?url=Reservation/apiRoomsFromReservation`, {
        headers: { 'Accept': 'application/json' }
      });
      const result = await response.json();
      if (!result.success) throw new Error(result.message);
      roomsContainer.innerHTML = '';
      result.data.forEach(room => {
        if (roomData.adults + roomData.children > parseInt(room.max_occupancy)) return; // Filter by occupancy
        const card = document.createElement('div');
        card.classList.add("room-card");
        card.dataset.max = room.max_occupancy;
        card.dataset.roomId = room.room_id;
        card.dataset.roomName = room.room_name;
        card.dataset.roomType = room.room_type;
        card.dataset.price = room.price;
        card.dataset.status = room.status;
        card.dataset.description = room.description;
        card.innerHTML = `
          <h3 class="room-title"><span class="fa fa-tag"></span><span>Offer</span></h3>
            <div class="room-container-body">
              <div class="room-picture">
                <img src="${room.room_picture}" alt="${room.room_type}">
              </div>
              <div class="flex room-container-block">
                <div class="room-left-block">
                  <div class="room-type"><strong>${room.room_name}</strong></div>
                  <div class="room-flex-wrap">
                    <div><strong>Max Occupancy</strong><div><i class="fa fa-user"></i> ${room.max_occupancy}</div></div>
                    <div><strong>Size</strong><div><i class="fa-solid fa-ruler"></i> ${room.size}</div></div>
                    <div><strong>Bed Type</strong><div><i class="fa fa-bed"></i> ${room.bed_type}</div></div>
                  </div>
                  <div class="room-status"><strong>Status:</strong> ${room.status}</div>
                  <div class="room-description">${room.description}</div>
                </div>
                <div class="room-right-block">
                  <div class="room-price-description">
                    <div class="dash-room-price"><strong>RM ${(parseFloat(room.price) + 600).toFixed(2)}</strong></div>
                    <div class="room-price"><strong>RM ${parseFloat(room.price).toFixed(2)}</strong></div>
                    <div class="flex avg-price">Avg per night</div>
                  </div>
                  ${room.status === "Available" ? `<button type="button" class="select-room-btn">Select Room</button>` : `<button type="button" disabled>Unavailable</button>`}
                </div>
              </div>
            </div>
        `;
        roomsContainer.appendChild(card);
        card.dataset.price = room.price;
      });
      filterRooms(); // Apply post-load filter
    } catch (e) {
      roomsContainer.innerHTML = `<p>Error: ${e.message}. Please refresh and try again.</p>`;
      console.error('loadRooms error:', e);
    }
  }

  // ---------------- Select room ----------------
  roomsContainer.addEventListener('click', (e) => {
    const btn = e.target.closest('.select-room-btn');
    if (!btn) return;
    const card = btn.closest('.room-card');
    roomData.selectedRoom = {
      room_id: card.dataset.roomId,
      room_type: card.dataset.roomType,
      price: card.dataset.price
    };
    hiddenRooms.value = roomData.selectedRoom.room_type;
    roomId.value = roomData.selectedRoom.room_id;
    hiddenRoomPrice.value = roomData.selectedRoom.price;
    document.getElementById('reservation-room').value = roomData.selectedRoom.room_type;
    renderCart();
  });

  // ---------------- Cart ----------------
  function renderCart() {
    cartDetails.innerHTML = "";
    const selectedRoomContainer = document.querySelector('.selected-room');
    const selectedRoomDetails = document.getElementById('selected-room-details');

    if (!roomData.selectedRoom) {
      cartDetails.innerHTML = "<p><em>No room selected yet</em></p>";
      totalAmountEl.textContent = "Total: RM 0.00";

      selectedRoomContainer.style.display = "none";
      selectedRoomDetails.innerHTML = "";

      formCheckout.style.display = "none";
      return;
    }

    const price = parseFloat(roomData.selectedRoom.price);
    const nights = checkInDate && checkOutDate ? Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24)) : 1;

    // Client-side price preview with discounts
    let totalPrice;
    if (roomData.adults === 1 && roomData.children === 0) {
      totalPrice = nights * price * 1.0; // Single: 0% discount
    } else if (roomData.adults > 1 && roomData.children === 0) {
      totalPrice = nights * price * 0.9; // Group: 10% off
    } else if (roomData.adults > 1 && roomData.children >= 1) {
      totalPrice = nights * price * 0.8; // Family: 20% off
    } else {
      totalPrice = nights * price;
    }

    const checkinStr = checkInDate ? checkInDate.toLocaleDateString('en-CA') : "—";
    const checkoutStr = checkOutDate ? checkOutDate.toLocaleDateString('en-CA') : "—";

    document.body.style.paddingBottom = "190px";
    // Cart details
    cartDetails.innerHTML = `
      <p><strong>Room:</strong> ${roomData.selectedRoom.room_type}</p>
      <p><strong>Guests:</strong> ${roomData.adults} Adults, ${roomData.children} Children</p>
      <p><strong>Check-in:</strong> ${checkinStr}</p>
      <p><strong>Check-out:</strong> ${checkoutStr}</p>
      <p><strong>Price:</strong> RM ${totalPrice.toFixed(2)}</p>
      <button type="button" onclick="removeRoom()">Remove</button>
    `;
    totalAmountEl.textContent = `Total: RM ${totalPrice.toFixed(2)}`;

    // Bottom selected-room section
    selectedRoomContainer.style.display = "block";
    selectedRoomDetails.innerHTML = `
      <p><strong>Room:</strong> ${roomData.selectedRoom.room_type}</p>
      <p><strong>Guests:</strong> ${roomData.adults} Adults, ${roomData.children} Children</p>
      <p><strong>Check-in:</strong> ${checkinStr}</p>
      <p><strong>Check-out:</strong> ${checkoutStr}</p>
      <p><strong>Price:</strong> RM ${totalPrice.toFixed(2)}</p>
    `;

    formCheckout.style.display = "flex"; // show checkout bar
  }

  function generateReservationID() {
    const now = new Date();
    const timestamp = now.toISOString().replace(/[-:T.]/g, '').slice(0, 14);
    const randomStr = Math.random().toString(36).substring(2, 6).toUpperCase();
    return `RES${timestamp}${randomStr}`;
  }

  window.removeRoom = function() {
    roomData.selectedRoom = null;
    hiddenRoomPrice.value = '';
    renderCart();
  };
  window.clearCart = function() {
    roomData.selectedRoom = null;
    hiddenRoomPrice.value = '';
    renderCart();
  };

  // ---------------- Cart popup ----------------
  function toggleCartPopup() {
    cartPopup.style.display = cartPopup.style.display === "block" ? "none" : "block";
  }
  window.toggleCartPopup = toggleCartPopup;

  // ---------------- Init ----------------
  hiddenAdults.value = 2;
  hiddenChildren.value = 0;
  generateCalendar();
  loadRooms();
  renderCart();
});

window.validateForm = function() {
  const nameInput = document.getElementById('reservation-name');

  if (!nameInput || !nameInput.value.trim()) {
    alert('Please enter your name');
    return false;
  }
  if (typeof window.checkInDate === 'undefined' || !window.checkInDate || !window.checkOutDate) {
    alert('Please select check-in and check-out dates');
    return false;
  }
  if (!window.roomData || !window.roomData.selectedRoom) {
    alert('Please select a room');
    return false;
  }
  if (window.roomData.adults < 1) {
    alert('At least one adult is required');
    return false;
  }
  if (!document.getElementById('reservation-room').value) {
    alert('Please select a room type');
    return false;
  }
  if (!document.getElementById('reservation-room-price').value || parseFloat(document.getElementById('reservation-room-price').value) <= 0) {
    alert('Invalid room price - please reselect room');
    return false;
  }

  return true;
};